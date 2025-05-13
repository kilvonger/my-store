@extends('layout.site', ['title' => $category->name])

@section('content')
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->content }}</p>

    <div class="bg-info p-2 mb-4">
        <!-- Фильтр для товаров категории -->
        @include('catalog.part.filter', [
            'action' => route('catalog.category', ['category' => $category->slug]),
            'resetUrl' => route('catalog.category', ['category' => $category->slug])
        ])
    </div>

    <div class="row">
        @foreach ($products as $product)
            @include('catalog.part.product', ['product' => $product])
        @endforeach
    </div>

    {{ $products->links() }}
@endsection