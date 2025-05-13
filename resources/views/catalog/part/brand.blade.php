<div class="col-md-4 mb-4">
    <a href="{{ route('catalog.brand', ['brand' => $brand->slug]) }}" class="card list-item text-decoration-none d-block">
        <!-- Изображение -->
        <div class="card-body p-0">
            @if ($brand->image)
                @php($url = url('storage/catalog/brand/thumb/' . $brand->image))
                <img src="{{ $url }}" class="img-fluid" alt="{{ $brand->name }}">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="{{ $brand->name }}">
            @endif
        </div>

        <!-- Текст под изображением -->
        <div class="card-footer bg-transparent border-0 text-center">
            <h3 class="mb-0 text-dark">{{ $brand->name }}</h3>
        </div>
    </a>
</div>
