@if ($paginator->hasPages())
    <div class="pagination_fg">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a href="#">«</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"> « </a>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="active"><span>{{ $page }}</span></a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
        @else
            <a href="#"> » </a>
        @endif
    </div>
@endif