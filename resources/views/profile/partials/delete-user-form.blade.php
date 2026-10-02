<section class="space-y-5">
    <header>
        <h2 class="pf-title" style="color:#fca5a5;">Xóa tài khoản</h2>

        <p class="pf-desc">
            Khi tài khoản bị xóa, toàn bộ dữ liệu liên quan sẽ bị xóa vĩnh viễn. Hãy tải về mọi thông tin bạn muốn giữ lại trước khi xóa tài khoản.
        </p>
    </header>

    <button
        type="button"
        class="pf-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Xóa tài khoản</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="pf-modal" style="padding:1.75rem; background:linear-gradient(180deg,#1f1f26,#19191f);">
            @csrf
            @method('delete')

            <h2 class="pf-title" style="color:#fca5a5;">
                Bạn có chắc muốn xóa tài khoản?
            </h2>

            <p class="pf-desc">
                Khi tài khoản bị xóa, toàn bộ dữ liệu sẽ bị xóa vĩnh viễn. Vui lòng nhập mật khẩu để xác nhận bạn muốn xóa vĩnh viễn tài khoản này.
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="Mật khẩu" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="Mật khẩu"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" class="pf-btn-ghost" x-on:click="$dispatch('close')">Hủy</button>
                <button type="submit" class="pf-btn-danger-solid">Xóa tài khoản</button>
            </div>
        </form>
    </x-modal>
</section>
