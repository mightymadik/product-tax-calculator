@extends('layouts.app')

@section('content')
<div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
        Рассчитайте цену
    </h2>
    <form class="flex flex-col justify-center gap-4 m-auto" method="POST" action="/calculate">
        @csrf
        <select name="product_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }} EUR</option>
            @endforeach
        </select>
        <input type="text" name="tax_number" placeholder="Введите tax номер"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <button @click="open = true" type="submit"
            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Рассчитать</button>
    </form>
</div>
@if(session('result'))
    <div x-data="{ open: true }">
        <div x-show="open" x-transition.opacity.scale.75
            class="fixed inset-0 flex items-center justify-center" style="background: rgba(0, 0, 0, 0.5);">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full h-96 flex flex-col justify-between">
                <h2 class="text-xl font-semibold">Уведомление</h2>
                <p class="text-xl font-normal flex justify-center mt-4">{{ session('result') }}</p>

                <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg" @click="open = false">
                    Закрыть
                </button>
            </div>
        </div>
    </div>
@endif

@endsection