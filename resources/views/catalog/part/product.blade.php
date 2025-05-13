<div class="col-md-4 mb-4">
    <a href="{{ route('catalog.product', ['product' => $product->slug]) }}" class="card-link text-decoration-none">
        <div class="card list-item">
            <!-- Слайдер изображений -->
            <div class="product-images-slider position-relative">
                @if ($product->images->isNotEmpty())
                    @foreach ($product->images as $image)
                        <div>
                            <img src="{{ asset($image->image) }}" class="img-fluid" alt="{{ $product->name }}">
                        </div>
                    @endforeach
                @else
                    <div>
                        <img src="{{ $product->image ? url('storage/catalog/product/thumb/' . $product->image) : 'https://via.placeholder.com/300x150' }}"
                             class="img-fluid" alt="{{ $product->name }}">
                    </div>
                @endif

                <!-- Значки (новинка, лидер продаж, распродажа) -->
                <div class="position-absolute top-0 right-0 p-2">
                    @if($product->new)
                        <span class="badge bg-info text-white ml-1">Новинка</span>
                    @endif
                    @if($product->hit)
                        <span class="badge bg-danger ml-1">Лидер продаж</span>
                    @endif
                    @if($product->sale)
                        <span class="badge bg-success ml-1">Распродажа</span>
                    @endif
                </div>
            </div>

            <!-- Название товара и описание -->
            <div class="card-body p-3">
                <h3 class="card-title mb-2 text-black">{{ $product->name }}</h3>
                <p class="card-text text-muted small">{{ Str::limit($product->content, 60) }}</p>
                <p class="card-text text-black font-weight-bold">{{ $product->price }} ₽</p>
            </div>

            <!-- Кнопка "В корзину" -->
            <div class="card-footer bg-transparent border-0">
                <form action="{{ route('basket.add', ['id' => $product->id]) }}" method="post" class="d-inline add-to-basket">
                    @csrf
                    <button type="submit" class="btn btn-success w-100">В корзину</button>
                </form>
            </div>
        </div>
    </a>
</div>

<!-- Подключение CSS для Slick Slider -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css">

<!-- Подключение JavaScript для Slick Slider -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

<script>
    $(document).ready(function () {
        // Инициализация слайдера для всех карточек товаров
        $('.product-images-slider').each(function () {
            $(this).slick({
                dots: false, // Убираем точки
                arrows: false, // Убираем стрелки
                infinite: true, // Бесконечная прокрутка
                speed: 500, // Скорость анимации
                slidesToShow: 1, // Показывать одно изображение за раз
                adaptiveHeight: true, // Адаптивная высота
                autoplay: true, // Автоматическое перелистывание
                autoplaySpeed: 3000, // Интервал между перелистываниями (3 секунды)
            });
        });
    });
</script>

<style>
    /* Стили для слайдера */
    .product-images-slider {
        position: relative;
    }

    /* Изображения в слайдере */
    .product-images-slider img {
        width: 100%;
        height: auto;
        object-fit: cover; /* Сохраняем пропорции изображений */
    }
</style>