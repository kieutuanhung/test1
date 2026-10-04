{{--
    Partial: 1 thẻ sản phẩm (dùng chung cho trang chủ và trang lọc)
    Biến truyền vào: $product
--}}
@once
<style>
    .pc-card{flex-shrink:0;width:45%;max-width:280px;display:flex;flex-direction:column;border-radius:16px;overflow:hidden;
        background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;
        box-shadow:0 8px 20px rgba(0,0,0,.25);transition:transform .25s, border-color .25s, box-shadow .25s;}
    .pc-card:hover{transform:translateY(-4px);border-color:#e0392c;box-shadow:0 14px 28px rgba(224,57,44,.18);}
    .pc-media{display:block;position:relative;overflow:hidden;width:100%;height:280px;background:#26262d;}
    .pc-card:hover .img-swap-1,.pc-card:hover .img-swap-2{transform:scale(1.05);}
    .pc-badges{position:absolute;top:10px;left:10px;z-index:2;display:flex;flex-direction:column;gap:6px;}
    .pc-badge{min-width:46px;text-align:center;padding:4px 10px;border-radius:999px;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:#fff;box-shadow:0 2px 6px rgba(0,0,0,.35);}
    .pc-badge-hot{background:linear-gradient(135deg,#e0392c,#f26a2e);}
    .pc-badge-new{background:linear-gradient(135deg,#2563eb,#3b82f6);}
    .pc-body{display:flex;flex-direction:column;flex-grow:1;padding:14px 16px 16px;}
    .pc-cat{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#f26a2e;}
    .pc-name{margin-top:6px;font-size:14px;line-height:1.35;color:#fff;min-height:2.7em;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
    .pc-name a:hover{opacity:.7;}
    .pc-foot{margin-top:12px;display:flex;align-items:center;justify-content:space-between;gap:8px;}
    .pc-price{font-size:15px;font-weight:800;color:#fff;white-space:nowrap;}
    .pc-add{border:1px solid rgba(242,106,46,.55);background:rgba(242,106,46,.10);color:#fdba74;font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:6px 12px;border-radius:999px;cursor:pointer;white-space:nowrap;transition:all .15s;}
    .pc-add:hover{background:linear-gradient(135deg,#e0392c,#f26a2e);border-color:transparent;color:#fff;}
</style>
@endonce

<div class="pc-card snap-start">
    <a href="{{ route('shop.show', $product->slug) }}" class="pc-media">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" style="width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0; opacity:1; transition:opacity 1s ease-in-out, transform .5s ease;" class="img-swap-1">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" style="width:100%; height:100%; object-fit:cover; display:block; position:absolute; inset:0; opacity:0; transition:opacity 1s ease-in-out, transform .5s ease;" class="img-swap-2">
            @endif
        @else
            <div class="w-full h-full flex items-center justify-center text-neutral-500 text-xs uppercase tracking-widest2" style="position:absolute; inset:0;">Không có hình ảnh</div>
        @endif

        @if($product->is_best_seller || $product->is_new_arrival)
            <div class="pc-badges">
                @if($product->is_best_seller)
                    <span class="pc-badge pc-badge-hot" title="Best Seller">Hot</span>
                @endif
                @if($product->is_new_arrival)
                    <span class="pc-badge pc-badge-new" title="New Arrival">New</span>
                @endif
            </div>
        @endif
    </a>

    <div class="pc-body">
        <span class="pc-cat">{{ $product->category->name ?? 'Chưa phân loại' }}</span>
        <h3 class="pc-name">
            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
        </h3>

        <div class="pc-foot">
            <span class="pc-price">{{ number_format($product->price, 0, ',', '.') }} đ</span>

            @if(!Auth::check() || Auth::user()->role === 'customer')
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="pc-add">+ Thêm</button>
                </form>
            @endif
        </div>
    </div>
</div>
