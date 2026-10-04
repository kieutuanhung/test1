<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.25em] text-accent">Quản trị</p>
                <h2 class="text-xl md:text-2xl font-black uppercase tracking-wide text-white mt-1">
                    {{ __('Thêm sản phẩm mới') }}
                </h2>
            </div>
            <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        /* Nền sáng hơn, đồng bộ với trang quản lý danh mục */
        div.ad-wrap{
            background:
                radial-gradient(900px 380px at 12% -8%, rgba(224,57,44,.16), transparent 60%),
                radial-gradient(800px 380px at 95% 0%, rgba(245,158,11,.12), transparent 60%),
                #151519;
        }
        .ad-card{background:linear-gradient(180deg,#1f1f26,#19191f);border:1px solid #2e2e37;border-radius:16px;}
        .ad-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#a8a8b3;margin-bottom:.4rem;}
        .ad-input{width:100%;background-color:#16161b;border:1px solid #3a3a45;border-radius:999px;padding:.65rem .875rem .65rem 1.1rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .ad-input::placeholder{color:#8a8a96;}
        .ad-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        textarea.ad-input{border-radius:16px;padding-top:.8rem;padding-bottom:.8rem;}
        .ad-file{padding-top:.5rem;padding-bottom:.5rem;color:#b8b8c2;}
        .ad-file::file-selector-button{background-color:#2e2e37;color:#e5e5ee;border:0;border-radius:999px;padding:.4rem .9rem;margin-right:.75rem;font-size:12px;font-weight:600;cursor:pointer;transition:background-color .15s;}
        .ad-file::file-selector-button:hover{background-color:#3a3a45;}
        .ad-btn-red{display:inline-block;background:linear-gradient(135deg,#e0392c,#f26a2e);color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:999px;border:0;cursor:pointer;white-space:nowrap;transition:transform .15s, filter .15s;}
        .ad-btn-red:hover{filter:brightness(1.1);transform:translateY(-1px);}
        .ad-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #3a3a45;color:#b8b8c2;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:999px;white-space:nowrap;transition:all .15s;}
        .ad-btn-ghost:hover{border-color:#fff;color:#fff;}
        .ad-err{color:#f87171;font-size:12px;margin-top:.35rem;}
        .ad-hint{color:#8a8a96;font-size:12px;margin-top:.35rem;}
        .ad-flags{display:flex;flex-wrap:wrap;gap:1.5rem;border:1px solid rgba(96,165,250,.30);background:linear-gradient(135deg,rgba(96,165,250,.14),rgba(96,165,250,.03) 60%),#1c1c22;border-radius:14px;padding:1rem 1.25rem;}
    </style>

    <div class="py-8 bg-ink min-h-screen ad-wrap">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="ad-card" style="padding:1.75rem;">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:1.25rem;">
                    @csrf

                    <div>
                        <label class="ad-label">Danh mục sản phẩm</label>
                        <select name="category_id" class="ad-input" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="ad-label">Tên sản phẩm</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="ad-input" required>
                        @error('name') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem;">
                        <div>
                            <label class="ad-label">Giá bán (VNĐ)</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="ad-input" required>
                            @error('price') <p class="ad-err">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="ad-label">Size có sẵn</label>
                            <input type="text" name="sizes" placeholder="VD: S, M, L, XL" value="{{ old('sizes') }}" class="ad-input">
                            @error('sizes') <p class="ad-err">{{ $message }}</p> @enderror
                            <p class="ad-hint">Cách nhau bởi dấu phẩy. Để trống nếu không phân loại theo size.</p>
                        </div>
                    </div>

                    <div>
                        <label class="ad-label">Hình ảnh đại diện (ảnh chính)</label>
                        <input type="file" name="image" class="ad-input ad-file">
                        @error('image') <p class="ad-err">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="ad-label">Ảnh phụ (có thể chọn nhiều ảnh)</label>
                        <input type="file" name="images[]" multiple class="ad-input ad-file">
                        @error('images.*') <p class="ad-err">{{ $message }}</p> @enderror
                        <p class="ad-hint">Giữ Ctrl (Windows) hoặc Cmd (Mac) để chọn nhiều ảnh khi mở hộp thoại chọn file.</p>
                    </div>

                    <div>
                        <label class="ad-label">Mô tả sản phẩm</label>
                        <textarea name="description" rows="4" class="ad-input">{{ old('description') }}</textarea>
                    </div>

                    <div class="ad-flags">
                        <label style="display:flex; align-items:center; gap:.6rem; cursor:pointer;">
                            <input type="checkbox" name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#e0392c;">
                            <span style="color:#fff; font-size:13px; font-weight:600;">New Arrival</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:.6rem; cursor:pointer;">
                            <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }} style="width:16px; height:16px; accent-color:#e0392c;">
                            <span style="color:#fff; font-size:13px; font-weight:600;">Best Seller</span>
                        </label>
                    </div>

                    <div style="padding-top:1.25rem; border-top:1px solid #2e2e37; display:flex; justify-content:flex-end; gap:.75rem;">
                        <a href="{{ route('admin.products.index') }}" class="ad-btn-ghost">Hủy</a>
                        <button type="submit" class="ad-btn-red">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
