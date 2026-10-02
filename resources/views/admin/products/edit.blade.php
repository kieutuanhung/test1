<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="section-title">
                {{ __('Chỉnh sửa sản phẩm') }}
            </h2>
            <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        .ad-card{background-color:#101010;border:1px solid #262626;border-radius:16px;}
        .ad-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#737373;margin-bottom:.4rem;}
        .ad-input{width:100%;background-color:#171717;border:1px solid #404040;border-radius:8px;padding-top:.65rem;padding-bottom:.65rem;padding-left:.875rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .ad-input::placeholder{color:#737373;}
        .ad-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .ad-file{padding-top:.5rem;padding-bottom:.5rem;color:#a3a3a3;}
        .ad-file::file-selector-button{background-color:#262626;color:#e5e5e5;border:0;border-radius:6px;padding:.4rem .8rem;margin-right:.75rem;font-size:12px;font-weight:600;cursor:pointer;}
        .ad-file::file-selector-button:hover{background-color:#333;}
        .ad-btn-red{display:inline-block;background-color:#e0392c;color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:8px;border:0;cursor:pointer;white-space:nowrap;transition:background-color .15s;}
        .ad-btn-red:hover{background-color:#c42f23;}
        .ad-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #404040;color:#a3a3a3;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:8px;white-space:nowrap;transition:all .15s;}
        .ad-btn-ghost:hover{border-color:#fff;color:#fff;}
        .ad-err{color:#f87171;font-size:12px;margin-top:.35rem;}
        .ad-hint{color:#737373;font-size:12px;margin-top:.35rem;}
    </style>

    <div class="py-8 bg-ink min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="ad-card" style="padding:1.75rem;">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:1.25rem;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="ad-label">Danh mục sản phẩm</label>
                        <select name="category_id" class="ad-input" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="ad-label">Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="ad-input" required>
                        @error('name') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem;">
                        <div>
                            <label class="ad-label">Giá bán (VNĐ)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="ad-input" required>
                            @error('price') <p class="ad-err">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="ad-label">Size có sẵn</label>
                            <input type="text" name="sizes" placeholder="VD: S, M, L, XL" value="{{ old('sizes', $product->sizes) }}" class="ad-input">
                            @error('sizes') <p class="ad-err">{{ $message }}</p> @enderror
                            <p class="ad-hint">Cách nhau bởi dấu phẩy. Để trống nếu không phân loại theo size.</p>
                        </div>
                    </div>

                    <div>
                        <label class="ad-label">Hình ảnh đại diện (ảnh chính)</label>
                        @if($product->image)
                            <div style="margin-bottom:.6rem;">
                                <img src="{{ asset('storage/' . $product->image) }}" style="width:84px; height:84px; object-fit:cover; border-radius:10px; border:1px solid #333; display:block;">
                            </div>
                        @endif
                        <input type="file" name="image" class="ad-input ad-file">
                        @error('image') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="ad-label">Ảnh phụ hiện có</label>
                        @if($product->images->isNotEmpty())
                            <div style="display:flex; flex-wrap:wrap; gap:.9rem; margin-bottom:1rem; padding-top:.4rem;">
                                @foreach($product->images as $img)
                                    <div style="position:relative;">
                                        <img src="{{ asset('storage/' . $img->image_path) }}" style="width:84px; height:84px; object-fit:cover; border-radius:10px; border:1px solid #333; display:block;">
                                        {{-- Nút xóa trỏ tới form nằm NGOÀI form chính (xem cuối file) --}}
                                        <button type="submit" form="delete-image-{{ $img->id }}" title="Xóa ảnh này"
                                                style="position:absolute; top:-8px; right:-8px; width:22px; height:22px; border-radius:9999px; background-color:#e0392c; color:#fff; border:2px solid #101010; font-size:13px; font-weight:700; line-height:1; cursor:pointer; display:flex; align-items:center; justify-content:center;">×</button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="ad-hint" style="margin-top:0; margin-bottom:.75rem;">Chưa có ảnh phụ nào.</p>
                        @endif

                        <label class="ad-label">Thêm ảnh phụ mới (có thể chọn nhiều ảnh)</label>
                        <input type="file" name="images[]" multiple class="ad-input ad-file">
                        @error('images.*') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="ad-label">Mô tả sản phẩm</label>
                        <textarea name="description" rows="4" class="ad-input">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div style="display:flex; flex-wrap:wrap; gap:1.5rem; border:1px solid #262626; background-color:#171717; border-radius:8px; padding:1rem;">
                        <label style="display:flex; align-items:center; gap:.6rem; cursor:pointer;">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#e0392c;">
                            <span style="color:#fff; font-size:13px; font-weight:600;">New Arrival</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:.6rem; cursor:pointer;">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#e0392c;">
                            <span style="color:#fff; font-size:13px; font-weight:600;">Best Seller</span>
                        </label>
                    </div>

                    <div style="padding-top:1.25rem; border-top:1px solid #262626; display:flex; justify-content:flex-end; gap:.75rem;">
                        <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">Hủy</a>
                        <button type="submit" class="ad-btn-red">Cập nhật sản phẩm</button>
                    </div>
                </form>

                {{-- Các form xóa ảnh phụ: đặt NGOÀI form chính để tránh lồng form --}}
                @foreach($product->images as $img)
                    <form id="delete-image-{{ $img->id }}" action="{{ route('admin.products.destroyImage', $img->id) }}" method="POST" onsubmit="return confirm('Xóa ảnh này?')" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
