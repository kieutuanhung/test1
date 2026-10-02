<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h2 class="section-title">
                {{ __('Chỉnh sửa danh mục') }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" class="ad-btn-ghost">← Quay lại danh sách</a>
        </div>
    </x-slot>

    <style>
        .ad-card{background-color:#101010;border:1px solid #262626;border-radius:16px;}
        .ad-label{display:block;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:#737373;margin-bottom:.4rem;}
        .ad-input{width:100%;background-color:#171717;border:1px solid #404040;border-radius:8px;padding-top:.65rem;padding-bottom:.65rem;padding-left:.875rem;font-size:.875rem;color:#fff;transition:border-color .15s, box-shadow .15s;}
        .ad-input::placeholder{color:#737373;}
        .ad-input:focus{outline:none;border-color:#e0392c;box-shadow:0 0 0 1px #e0392c;}
        .ad-btn-red{display:inline-block;background-color:#e0392c;color:#fff;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.4rem;border-radius:8px;border:0;cursor:pointer;white-space:nowrap;transition:background-color .15s;}
        .ad-btn-red:hover{background-color:#c42f23;}
        .ad-btn-ghost{display:inline-flex;align-items:center;justify-content:center;border:1px solid #404040;color:#a3a3a3;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;padding:.75rem 1.2rem;border-radius:8px;white-space:nowrap;transition:all .15s;}
        .ad-btn-ghost:hover{border-color:#fff;color:#fff;}
        .ad-err{color:#f87171;font-size:12px;margin-top:.35rem;}
    </style>

    <div class="py-8 bg-ink min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="ad-card" style="padding:1.75rem;">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" style="display:flex; flex-direction:column; gap:1.25rem;">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="ad-label">Tên danh mục</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="ad-input">
                        @error('name')
                            <p class="ad-err">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="ad-label">Mô tả danh mục</label>
                        <textarea name="description" rows="4" class="ad-input">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="ad-err">{{ $message }}</p>
                        @enderror
                    </div>

                    <div style="padding-top:1.25rem; border-top:1px solid #262626; display:flex; justify-content:flex-end; gap:.75rem;">
                        <a href="{{ route('admin.categories.index') }}" class="ad-btn-ghost">Hủy</a>
                        <button type="submit" class="ad-btn-red">Cập nhật danh mục</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
