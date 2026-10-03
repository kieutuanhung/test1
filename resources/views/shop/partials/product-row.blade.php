{{--
    Partial: 1 dòng sản phẩm cuộn ngang có tiêu đề + nút "Xem tất cả"
    Biến truyền vào:
    - $rowProducts   : danh sách sản phẩm
    - $rowTitle      : tiêu đề khu vực (VD: "New Arrival")
    - $rowViewAllUrl : (tùy chọn) link "Xem tất cả"
    - $rowId         : id duy nhất cho khung cuộn (để id không trùng)
    - $rowEyebrow    : (tùy chọn) dòng cam nhỏ phía trên tiêu đề
--}}
@php
    $eyebrow = $rowEyebrow ?? (
        $rowId === 'bestseller' ? 'Được yêu thích' : ($rowId === 'newarrival' ? 'Mới về' : 'Danh mục')
    );
@endphp
@once
<style>
    .pr-section{background:radial-gradient(800px 320px at 10% 0%, rgba(224,57,44,.10), transparent 60%), #141418;}
    .pr-eyebrow{font-size:11px;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#f26a2e;}
    .pr-title{margin-top:4px;font-size:1.5rem;font-weight:900;letter-spacing:.04em;text-transform:uppercase;color:#fff;}
    .pr-viewall{display:inline-flex;align-items:center;white-space:nowrap;border:1px solid rgba(242,106,46,.55);color:#fdba74;background:rgba(242,106,46,.08);font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.6rem 1.2rem;border-radius:999px;transition:all .15s;}
    .pr-viewall:hover{background:linear-gradient(135deg,#e0392c,#f26a2e);border-color:transparent;color:#fff;}
</style>
@endonce
<div class="pr-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-8">
            <div>
                <p class="pr-eyebrow">{{ $eyebrow }}</p>
                <h2 class="pr-title">{{ $rowTitle }}</h2>
            </div>
            @isset($rowViewAllUrl)
                <a href="{{ $rowViewAllUrl }}" class="pr-viewall">Xem tất cả &rarr;</a>
            @endisset
        </div>

        <div class="relative">
            <div id="track-{{ $rowId }}" class="flex gap-6 overflow-x-auto pt-2 pb-5 snap-x snap-mandatory scroll-smooth [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                @foreach($rowProducts as $product)
                    @include('shop.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <button type="button" id="prev-{{ $rowId }}" onclick="document.getElementById('track-{{ $rowId }}').scrollBy({ left: -document.getElementById('track-{{ $rowId }}').clientWidth * 0.9, behavior: 'smooth' })"
                    style="z-index:30; cursor:pointer;"
                    class="hidden md:flex items-center justify-center absolute top-1/3 -left-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            </button>
            <button type="button" id="next-{{ $rowId }}" onclick="document.getElementById('track-{{ $rowId }}').scrollBy({ left: document.getElementById('track-{{ $rowId }}').clientWidth * 0.9, behavior: 'smooth' })"
                    style="z-index:30; cursor:pointer;"
                    class="hidden md:flex items-center justify-center absolute top-1/3 -right-5 -translate-y-1/2 w-12 h-12 rounded-full bg-white text-ink shadow-lg hover:bg-accent hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>
    </div>
</div>

<script>
(function () {
    var track = document.getElementById('track-{{ $rowId }}');
    var prevBtn = document.getElementById('prev-{{ $rowId }}');
    var nextBtn = document.getElementById('next-{{ $rowId }}');

    function updateArrows() {
        if (!track) return;
        var canScroll = track.scrollWidth > track.clientWidth + 5; // +5 để tránh lệch số thập phân
        [prevBtn, nextBtn].forEach(function (btn) {
            if (!btn) return;
            btn.style.display = canScroll ? '' : 'none'; // '' = quay lại dùng class hidden md:flex mặc định
        });
    }

    window.addEventListener('load', updateArrows);
    window.addEventListener('resize', updateArrows);
    // Chạy luôn 1 lần ngay khi script thực thi (phòng trường hợp ảnh load chậm làm sai kích thước ban đầu)
    setTimeout(updateArrows, 300);
})();

// Tự động đổi sang ảnh thứ 2 mỗi 10 giây cho các thẻ sản phẩm có nhiều hơn 1 ảnh
// (chỉ đăng ký 1 lần duy nhất cho toàn trang, dù partial này được include nhiều lần)
if (!window.__productImgSwapInit) {
    window.__productImgSwapInit = true;
    setInterval(function () {
        document.querySelectorAll('.img-swap-2').forEach(function (img2) {
            var img1 = img2.previousElementSibling;
            if (!img1 || !img1.classList.contains('img-swap-1')) return;
            var showing2 = img2.style.opacity === '1';
            img1.style.opacity = showing2 ? '1' : '0';
            img2.style.opacity = showing2 ? '0' : '1';
        });
    }, 5000);
}
</script>
