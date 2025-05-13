<ul>
    @foreach ($items->where('parent_id', $parent) as $item)
        <li>
            <a href="{{ route('catalog.category', ['category' => $item->slug]) }}">{{ $item->name }}</a>
            @if (count($items->where('parent_id', $item->id)))
                <span class="badge badge-dark toggle-category" data-target="branch-{{ $item->id }}">
                    <i class="fas fa-plus"></i> <!-- Значок плюсика -->
                </span>
                <ul id="branch-{{ $item->id }}" class="nested-category" style="display: none;">
                    @include('layout.part.branch', ['parent' => $item->id])
                </ul>
            @endif
        </li>
    @endforeach
</ul>