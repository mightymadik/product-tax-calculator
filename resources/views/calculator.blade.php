@extends('layouts.app')

@section('content')
    <form method="POST" action="/calculate">
        @csrf
        <select name="product_id">
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->price }} EUR</option>
            @endforeach
        </select>
        <input type="text" name="tax_number" placeholder="Введите tax номер">
        <button type="submit">Рассчитать</button>
    </form>

    @if(session('result'))
        <p>{{ session('result') }}</p>
    @endif
@endsection
