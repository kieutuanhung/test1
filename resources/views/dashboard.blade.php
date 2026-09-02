<x-app-layout>
    <x-slot name="header">
        <h2 class="section-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-ink border border-neutral-800">
                <div class="p-6 text-white text-sm">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
