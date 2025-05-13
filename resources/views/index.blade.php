@extends('layout.site')

@section('content')
    <div class="jumbotron jumbotron-fluid bg-light text-center mb-4">
        <div class="container">
            <h1 class="display-4">Добро пожаловать в <br> Sport-Universe!</h1>
            <p class="lead">Мы предлагаем широкий выбор профессиональных тренажёров для дома и залов.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg">Перейти в каталог</a>
        </div>
    </div>

    <!-- Секция "Новинки" -->
    @if($new->count())
        <h2 class="text-center mb-4">Новинки</h2>
        <div class="row">
            @foreach($new as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif

    <!-- Секция "Лидеры продаж" -->
    @if($hit->count())
        <h2 class="text-center mb-4">Лидеры продаж</h2>
        <div class="row">
            @foreach($hit as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif

    <!-- Секция "Распродажа" -->
    @if($sale->count())
        <h2 class="text-center mb-4">Распродажа</h2>
        <div class="row">
            @foreach($sale as $item)
                @include('catalog.part.product', ['product' => $item])
            @endforeach
        </div>
    @endif
@endsection
