<h4>Популярные бренды</h4>
<ul id="brands-popular">
@foreach($items as $item)
    <li>
        <a href="{{ route('catalog.brand', ['brand' => $item->slug]) }}">{{ $item->name }}</a>
    </li>
@endforeach
</ul>
