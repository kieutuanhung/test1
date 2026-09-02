<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            Chi Tiết Đơn Hàng #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12 bg-ink min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-none ">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Thông tin khách hàng & Form đổi trạng thái -->
                <div class="bg-ink p-6 rounded-none border-2 border-white  space-y-3">
                    <h3 class="font-bold text-white border-b border-neutral-800 pb-2">Thông Tin Nhận Hàng</h3>
                    <p class="text-sm"><b>Khách hàng:</b> {{ $order->customer_name }}</p>
                    <p class="text-sm"><b>Số ĐT:</b> {{ $order->customer_phone }}</p>
                    <p class="text-sm"><b>Email:</b> {{ $order->customer_email ?: 'Không có' }}</p>
                    <p class="text-sm"><b>Địa chỉ:</b> {{ $order->customer_address }}</p>
                    <p class="text-sm"><b>Ghi chú:</b> {{ $order->note ?: 'Không có' }}</p>

                    <!-- Form cập nhật trạng thái -->
			<form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-4">
    @csrf
    @method('PATCH')
    
    <label class="block text-xs font-bold text-neutral-200 uppercase mb-2">Cập nhật trạng thái:</label>
    
    <select name="status" class="w-full bg-neutral-900 rounded-none border-neutral-700 focus:border-accent focus:ring focus:ring-accent text-sm mb-3 text-white">
        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
            ⏳ 1. Chờ gom hàng (Pending)
        </option>
        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
            📦 2. Đang nhập & Đóng gói (Processing)
        </option>
        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
            ✅ 3. Hoàn thành / Đã giao (Completed)
        </option>
        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
            ❌ 4. Hủy đơn (Cancelled)
        </option>
    </select>

    <button type="submit" class="w-full bg-accent hover:bg-accent-700 text-white font-bold py-2 px-4 rounded-none transition shadow">
        Lưu trạng thái
    </button>
</form>
                </div>

                <!-- Danh sách sản phẩm mua -->
                <div class="md:col-span-2 bg-ink p-6 rounded-none border-2 border-white ">
                    <h3 class="font-bold text-white border-b border-neutral-800 pb-2 mb-4">Danh sách sản phẩm</h3>
                    <table class="min-w-full divide-y divide-neutral-800 text-sm">
                        <thead>
                            <tr class="text-neutral-500 uppercase text-xs">
                                <th class="text-left pb-2">Tên sản phẩm</th>
                                <th class="text-center pb-2">Số lượng</th>
                                <th class="text-right pb-2">Đơn giá</th>
                                <th class="text-right pb-2">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-800">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-12 h-12 object-cover bg-neutral-800 rounded-lg shrink-0">
                                            @else
                                                <div class="w-12 h-12 bg-neutral-800 rounded-lg shrink-0"></div>
                                            @endif
                                            <span class="font-medium text-white">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                    <td class="py-3 text-right font-bold text-white">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-t border-neutral-800 mt-6 pt-4 text-right">
                        <span class="text-neutral-400 mr-2 font-medium">Tổng tiền đơn hàng:</span>
                        <span class="text-2xl font-black text-white">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
