@extends('layout.site')

@section('content')
<!-- Подключение CSS для Slick Slider -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css">

<div class="container mt-5">
    <div class="row">
        <!-- Левая колонка: Изображения -->
        <div class="col-md-6">
            <div class="position-relative">
                <!-- Слайдер изображений -->
                <div class="product-images-slider mb-3">
                    @if ($product->images->isNotEmpty())
                        @foreach ($product->images as $image)
                            <div>
                                <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="img-fluid rounded clickable-image" data-image="{{ asset($image->image) }}">
                            </div>
                        @endforeach
                    @else
                        <div>
                            <img src="{{ $product->image ? url('storage/catalog/product/image/' . $product->image) : 'https://via.placeholder.com/600x300' }}"
                                 alt="{{ $product->name }}" class="img-fluid rounded clickable-image" data-image="{{ $product->image ? url('storage/catalog/product/image/' . $product->image) : 'https://via.placeholder.com/600x300' }}">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Правая колонка: Информация о товаре -->
        <div class="col-md-6">
            <h1 class="mb-4">{{ $product->name }}</h1>

            <!-- Цена -->
            <p class="text-black mb-4" style="font-size: 1.5rem; font-weight: bold;">{{ number_format($product->price, 2, '.', '') }} ₽</p>

            <!-- Форма добавления в корзину -->
            <form action="{{ route('basket.add', ['id' => $product->id]) }}" method="post" class="add-to-basket">
                @csrf
                <div class="mb-3">
                    <label for="input-quantity" class="form-label fw-bold">Количество</label>
                    <input type="number" name="quantity" id="input-quantity" value="1" class="form-control w-25" min="1">
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100">Добавить в корзину</button>
            </form>

            <!-- Категория и бренд -->
            <div class="mt-4">
                <p>
                    @isset($product->category)
                        <strong>Категория:</strong>
                        <a href="{{ route('catalog.category', ['category' => $product->category->slug]) }}">
                            {{ $product->category->name }}
                        </a>
                    @endisset
                </p>
                <p>
                    @isset($product->brand)
                        <strong>Бренд:</strong>
                        <a href="{{ route('catalog.brand', ['brand' => $product->brand->slug]) }}">
                            {{ $product->brand->name }}
                        </a>
                    @endisset
                </p>
            </div>
        </div>
    </div>

    <!-- Описание товара -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Описание</h3>
            <p>{{ $product->content }}</p>
        </div>
    </div>
</div>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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
        $('.product-images-slider img').on('click', function () {
            const imageSrc = $(this).data('image'); // Получаем путь к изображению
            $('#modalImage').attr('src', imageSrc); // Устанавливаем путь в модальное окно
            $('#imageModal').modal('show'); // Открываем модальное окно
        });
    });
</script>

<!-- Стили для стрелок -->
<style>
    /* Стили для бейджей */
    .badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }

    /* Стили для цены */
    p.text-black {
        font-size: 1.5rem;
        font-weight: bold;
        color: #000;
    }

    /* Стили для кнопки "Добавить в корзину" */
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    /* Стили для стрелок слайдера */
    .slick-prev,
    .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        color: #000; /* Чёрные стрелки */
        background-color: transparent; /* Без фона */
        border: none;
        padding: 0.5rem;
        cursor: pointer;
        z-index: 1;
    }
    .slick-prev {
        left: 10px;
    }
    .slick-next {
        right: 10px;
    }

    /* Стили для модального окна */
    #imageModal .modal-content {
        background-color: #f8f9fa;
    }
</style>
@endsection