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
        // Doanh thu = đơn ĐÃ THANH TOÁN (QR) ngay từ lúc chờ gom hàng.
        // Đơn đã hoàn tiền có payment_status = 'refunded' nên tự động bị trừ khỏi doanh thu.
        $totalRevenue = $filterByMonth(Order::where('payment_status', 'paid'))->sum('total_price');
        $totalOrders = $filterByMonth(Order::query())->count();
        $processingOrders = $filterByMonth(Order::where('status', 'processing'))->count();
        $completedOrders = $filterByMonth(Order::where('status', 'completed'))->count();
        $cancelledOrders = $filterByMonth(Order::where('status', 'cancelled'))->count();

        // Đơn "Chờ gom hàng" cũng theo tháng đã chọn
        $pendingOrders = $filterByMonth(Order::where('status', 'pending'))->count();

        // 2. Danh sách sản phẩm cần gom nhập về từ các đơn 'pending' (theo tháng đã chọn)
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
            ->whereYear('orders.created_at', $year)
            ->whereMonth('orders.created_at', $month)
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
                $query->where('payment_status', 'paid') // bỏ đơn chưa thanh toán / đã hoàn tiền
                      ->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Dữ liệu mảng truyền cho Pie Chart
        $productLabels = $topProducts->pluck('product_name')->toArray();
        $productRevenues = $topProducts->pluck('revenue')->toArray();

        // 4. 5 đơn hàng mới nhất của tháng đã chọn
        $recentOrders = $filterByMonth(Order::query())->latest()->take(5)->get();

        // Gắn kèm tên sản phẩm cho từng đơn (không phụ thuộc quan hệ items() có khai báo trong Model Order hay không)
        $recentOrderIds = $recentOrders->pluck('id');
        $itemsByOrder = OrderItem::whereIn('order_id', $recentOrderIds)
            ->get()
            ->groupBy('order_id');

        $recentOrders->each(function ($order) use ($itemsByOrder) {
            $names = $itemsByOrder->get($order->id, collect())->pluck('product_name');
            $shown = $names->take(2)->implode(', ');
            $extra = $names->count() > 2 ? ' +' . ($names->count() - 2) : '';
            $order->product_names_display = $names->isEmpty() ? '—' : $shown . $extra;
        });

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
