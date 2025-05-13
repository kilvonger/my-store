<div class="col-md-4 mb-4">
    <a href="{{ route('catalog.category', ['category' => $category->slug]) }}" class="card list-item text-decoration-none d-block">
        <!-- Изображение -->
        <div class="card-body p-0">
            @if ($category->image)
                @php($url = url('storage/catalog/category/thumb/' . $category->image))
                <img src="{{ $url }}" class="img-fluid" alt="{{ $category->name }}">
            @else
                <img src="https://via.placeholder.com/300x150" class="img-fluid" alt="{{ $category->name }}">
            @endif
        </div>

        <!-- Текст под изображением -->
        <div class="card-footer bg-transparent border-0 text-center">
            <h3 class="mb-0 text-dark">{{ $category->name }}</h3>
        </div>
    </a>
</div>