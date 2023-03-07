{{-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-jet-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
--}}

<x-vinylshop-layout>
    <x-slot name="description">dashboard</x-slot>
    <x-slot name="title">{{ auth()->user()->name }}'s Dashboard</x-slot>

    <x-tmk.section>
        <x-jet-welcome/>
    </x-tmk.section>
</x-vinylshop-layout>
