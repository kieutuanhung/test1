# Hướng dẫn dùng gói này

## Cấu trúc thư mục (dựa theo @include trong file index.blade.php của bạn)

```
resources/views/shop/index.blade.php              <- ĐÃ SỬA: thêm ảnh nền hero
resources/views/shop/partials/product-row.blade.php <- giữ nguyên, không đổi gì
resources/views/shop/show.blade.php                <- giữ nguyên, không đổi gì
public/images/                                      <- thư mục trống, thả ảnh vào đây
```

## Cách dùng
1. Giải nén file zip này.
2. Copy toàn bộ thư mục `resources` và `public` đè vào project Laravel của bạn
   (xác nhận đúng ghi đè, KHÔNG xóa các file khác trong project).
3. Đặt ảnh nền hero của bạn vào: `public/images/hero-bg.jpg`
   (nếu muốn tên khác, mở `resources/views/shop/index.blade.php`,
   sửa dòng `background-image: url('{{ asset('images/hero-bg.jpg') }}')`)

## Lưu ý quan trọng
Tôi giả định file `index.blade.php` của bạn nằm ở đúng đường dẫn
`resources/views/shop/index.blade.php`, dựa theo dòng
`@include('shop.partials.product-row', ...)` có trong file.

Nếu thực tế project bạn đặt file ở vị trí KHÁC (ví dụ
`resources/views/home.blade.php` hoặc route trỏ tới view khác),
bạn kiểm tra lại trong `routes/web.php` xem route `/` (trang chủ)
đang gọi `view('...')` tên gì, rồi đặt file đúng theo tên đó —
tránh lặp lại sự cố ghi đè nhầm lần trước.

`product-row.blade.php` và `show.blade.php` mình đóng gói kèm theo
NGUYÊN VẸN (không sửa gì) — chỉ để bạn có bộ 3 file đầy đủ, đúng vị trí,
copy-paste một lần cho chắc ăn, không cần tự dò từng file.
