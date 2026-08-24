<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-pink-600 leading-tight">
            Chi Tiết Đơn Hàng #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12 bg-pink-50/40 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Thông tin khách hàng & Form đổi trạng thái -->
                <div class="bg-white p-6 rounded-2xl border border-pink-100 shadow-sm space-y-3">
                    <h3 class="font-bold text-pink-600 border-b border-pink-100 pb-2">Thông Tin Nhận Hàng</h3>
                    <p class="text-sm"><b>Khách hàng:</b> {{ $order->customer_name }}</p>
                    <p class="text-sm"><b>Số ĐT:</b> {{ $order->customer_phone }}</p>
                    <p class="text-sm"><b>Email:</b> {{ $order->customer_email ?: 'Không có' }}</p>
                    <p class="text-sm"><b>Địa chỉ:</b> {{ $order->customer_address }}</p>
                    <p class="text-sm"><b>Ghi chú:</b> {{ $order->note ?: 'Không có' }}</p>

                    <!-- Form cập nhật trạng thái -->
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="pt-4 border-t border-pink-100">
                        @csrf
                        @method('PATCH')
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Cập nhật trạng thái:</label>
                        <select name="status" class="w-full rounded-xl border-pink-200 text-sm mb-3">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                        </select>
                        <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 rounded-xl text-sm transition shadow">
                            Lưu trạng thái
                        </button>
                    </form>
                </div>

                <!-- Danh sách sản phẩm mua -->
                <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-pink-100 shadow-sm">
                    <h3 class="font-bold text-pink-600 border-b border-pink-100 pb-2 mb-4">Danh sách sản phẩm</h3>
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="text-left pb-2">Tên sản phẩm</th>
                                <th class="text-center pb-2">Số lượng</th>
                                <th class="text-right pb-2">Đơn giá</th>
                                <th class="text-right pb-2">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="py-3 font-medium text-gray-800">{{ $item->product_name }}</td>
                                    <td class="py-3 text-center">{{ $item->quantity }}</td>
                                    <td class="py-3 text-right">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                    <td class="py-3 text-right font-bold text-pink-600">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="border-t border-pink-100 mt-6 pt-4 text-right">
                        <span class="text-gray-500 mr-2 font-medium">Tổng tiền đơn hàng:</span>
                        <span class="text-2xl font-black text-pink-600">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
