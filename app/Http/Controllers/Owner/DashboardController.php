<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tháng đang xem báo cáo (mặc định = tháng hiện tại). Định dạng: YYYY-MM
        $selectedMonth = $request->input('month', now()->format('Y-m'));
        [$year, $month] = explode('-', $selectedMonth);

        // Áp khoảng thời gian của tháng đã chọn cho mọi truy vấn báo cáo bên dưới
        $filterByMonth = function ($query) use ($year, $month) {
            return $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        };

        // 1. Thống kê tiền & số lượng đơn (theo tháng đã chọn)
        $totalRevenue = $filterByMonth(Order::where('status', 'completed'))->sum('total_price');
        $totalOrders = $filterByMonth(Order::query())->count();
        $processingOrders = $filterByMonth(Order::where('status', 'processing'))->count();
        $completedOrders = $filterByMonth(Order::where('status', 'completed'))->count();
        $cancelledOrders = $filterByMonth(Order::where('status', 'cancelled'))->count();

        // "Chờ gom hàng" luôn hiện TOÀN BỘ đơn đang pending (việc cần làm ngay), không lọc theo tháng
        $pendingOrders = Order::where('status', 'pending')->count();

        // 2. Danh sách sản phẩm cần gom nhập về từ các đơn 'pending' (luôn hiện tại, không theo tháng)
        // Hỗ trợ sắp xếp theo: số lượng cần lấy (mặc định) / thời gian đặt gần nhất / số đơn hàng / số tiền
        $restockSort = $request->input('restock_sort', 'quantity');

        $itemsToRestockQuery = OrderItem::select(
                'order_items.product_name',
                DB::raw('SUM(order_items.quantity) as total_needed'),
                DB::raw('COUNT(DISTINCT order_items.order_id) as total_orders'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_amount'),
                DB::raw('MAX(orders.created_at) as latest_order_at')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'pending')
            ->whereHas('activeProduct') // bỏ qua sản phẩm đã ngừng bán (xóa mềm)
            ->when($request->filled('restock_search'), function ($query) use ($request) {
                $query->where('order_items.product_name', 'like', '%' . $request->restock_search . '%');
            })
            ->groupBy('order_items.product_name');

        match ($restockSort) {
            'time'   => $itemsToRestockQuery->orderByDesc('latest_order_at'),
            'orders' => $itemsToRestockQuery->orderByDesc('total_orders'),
            'amount' => $itemsToRestockQuery->orderByDesc('total_amount'),
            default  => $itemsToRestockQuery->orderByDesc('total_needed'),
        };

        $itemsToRestock = $itemsToRestockQuery->get();

        // 3. Top 5 sản phẩm bán chạy & Doanh thu tương ứng (theo tháng đã chọn)
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price * quantity) as revenue'))
            ->whereHas('order', function ($query) use ($year, $month) {
                $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Dữ liệu mảng truyền cho Pie Chart
        $productLabels = $topProducts->pluck('product_name')->toArray();
        $productRevenues = $topProducts->pluck('revenue')->toArray();

        // 4. 5 đơn hàng mới nhất (luôn hiện mới nhất thật, không theo tháng)
        $recentOrders = Order::latest()->take(5)->get();

        // Danh sách các tháng có phát sinh đơn hàng, để đổ vào dropdown chọn tháng
        $availableMonths = Order::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym")
            ->distinct()
            ->orderByDesc('ym')
            ->pluck('ym');

        // Đảm bảo tháng hiện tại luôn có mặt trong dropdown dù chưa có đơn nào
        if (!$availableMonths->contains(now()->format('Y-m'))) {
            $availableMonths = $availableMonths->prepend(now()->format('Y-m'))->unique()->values();
        }

        return view('owner.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'itemsToRestock',
            'restockSort',
            'topProducts',
            'productLabels',
            'productRevenues',
            'recentOrders',
            'selectedMonth',
            'availableMonths'
        ));
    }
}
