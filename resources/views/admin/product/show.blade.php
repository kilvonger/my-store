@extends('layout.admin', ['title' => 'Просмотр товара'])

@section('content')
<!-- Подключение CSS для Slick Slider -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css">

<h1>Просмотр товара</h1>
<div class="row">
    <div class="col-md-6">
        <p><strong>Название:</strong> {{ $product->name }}</p>
        <p><strong>ЧПУ (англ):</strong> {{ $product->slug }}</p>
        <p><strong>Бренд:</strong> {{ $product->brand->name }}</p>
        <p><strong>Категория:</strong> {{ $product->category->name }}</p>
        <p><strong>Новинка:</strong> @if($product->new) да @else нет @endif</p>
        <p><strong>Лидер продаж:</strong> @if($product->hit) да @else нет @endif</p>
        <p><strong>Распродажа:</strong> @if($product->sale) да @else нет @endif</p>
        <p><strong>Описание</strong></p>
        @isset($product->content)
            <p>{{ $product->content }}</p>
        @else
            <p>Описание отсутствует</p>
        @endisset
        <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}" class="btn btn-success">
            Редактировать товар
        </a>
        <form method="post" class="d-inline" onsubmit="return confirm('Удалить этот товар?')" action="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Удалить товар
            </button>
        </form>
    </div>
    <div class="col-md-6">
        <!-- Слайдер изображений -->
        <div class="product-images-slider">
            @if ($product->images->isNotEmpty())
                @foreach ($product->images as $image)
                    <div>
                        <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="img-fluid" data-image="{{ asset($image->image) }}">
                    </div>
                @endforeach
            @else
                <div>
                    <img src="{{ url('storage/catalog/product/image/default.jpg') }}" alt="{{ $product->name }}" class="img-fluid" data-image="{{ url('storage/catalog/product/image/default.jpg') }}">
                </div>
            @endif
        </div>
    </div>
</div>

<!-- <div class="row mt-4">
    <div class="col-12">
        <p><strong>Описание</strong></p>
        @isset($product->content)
            <p>{{ $product->content }}</p>
        @else
            <p>Описание отсутствует</p>
        @endisset
        <a href="{{ route('admin.product.edit', ['product' => $product->id]) }}" class="btn btn-success">
            Редактировать товар
        </a>
        <form method="post" class="d-inline" onsubmit="return confirm('Удалить этот товар?')" action="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Удалить товар
            </button>
        </form>
    </div>
</div> -->

<!-- Модальное окно для увеличенного изображения -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img src="" alt="{{ $product->name }}" class="img-fluid" id="modalImage">
            </div>
        </div>
    </div>
</div>

<!-- Подключение JavaScript для Slick Slider -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

<script>
    $(document).ready(function () {
        // Инициализация слайдера
        $('.product-images-slider').slick({
            dots: true, // Показывать точки для навигации
            infinite: true, // Бесконечная прокрутка
            speed: 300, // Скорость анимации
            slidesToShow: 1, // Показывать одно изображение за раз
            adaptiveHeight: true, // Адаптивная высота
            prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>', // Стрелка "назад"
            nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>', // Стрелка "вперёд"
        });

        // Обработчик клика на изображение
        $(document).on('click', '.product-images-slider img', function () {
            const imageSrc = $(this).data('image'); // Получаем путь к изображению
            $('#modalImage').attr('src', imageSrc); // Устанавливаем путь в модальное окно
            $('#imageModal').modal('show'); // Открываем модальное окно
        });
    });
</script>

<!-- Стили для стрелок -->
<style>
/* Базовые стили для слайдера */
.product-images-slider {
    position: relative; /* Для позиционирования стрелок */
}

/* Стили для стрелок */
.slick-prev,
.slick-next {
    position: absolute;
    top: 50%; /* Размещаем по центру по высоте */
    transform: translateY(-50%); /* Центрируем по вертикали */
    font-size: 2rem; /* Размер стрелок */
    color: #000; /* Чёрный цвет */
    background-color: transparent; /* Убираем фон */
    border: none; /* Убираем границу */
    padding: 0.5rem; /* Отступы вокруг стрелок */
    cursor: pointer;
    z-index: 1; /* Поверх изображений */
    transition: color 0.3s ease; /* Анимация при наведении */
}

.slick-prev {
    left: 10px; /* Отступ слева */
}

.slick-next {
    right: 10px; /* Отступ справа */
}

/* При наведении */
.slick-prev:hover,
.slick-next:hover {
    color: #333; /* Темнее цвет */
}
</style>
@endsection