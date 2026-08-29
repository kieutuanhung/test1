<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê tiền & số lượng đơn
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        // 2. Danh sách sản phẩm cần gom nhập về từ các đơn 'pending'
        $itemsToRestock = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_needed'))
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending');
            })
            ->groupBy('product_name')
            ->orderByDesc('total_needed')
            ->get();

        // 3. Top 5 sản phẩm bán chạy & Doanh thu tương ứng
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(price * quantity) as revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Dữ liệu mảng truyền cho Pie Chart
        $productLabels = $topProducts->pluck('product_name')->toArray();
        $productRevenues = $topProducts->pluck('revenue')->toArray();

        // 4. 5 đơn hàng mới nhất
        $recentOrders = Order::latest()->take(5)->get();

        return view('owner.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'cancelledOrders',
            'itemsToRestock',
            'topProducts',
            'productLabels',
            'productRevenues',
            'recentOrders'
        ));
    }
}
