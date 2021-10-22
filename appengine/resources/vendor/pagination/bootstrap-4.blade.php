@if ($paginator->hasPages())
        <ul>
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled">
                    <a href="{{ $paginator->previousPageUrl() }}" class="prev"> <i class="flaticon-left-arrow"></i>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="prev"> <i class="flaticon-left-arrow"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="third_pagger" aria-current="page"><a href="#">{{ $page }}</a></li>
                        @else
                            <li class="d-block d-sm-block d-md-block d-lg-block"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="disabled">
                    <a href="{{ $paginator->nextPageUrl() }}" class="next"> <i class="flaticon-right-arrow"></i>
                    </>
                </li>
            @else
                <li class="disabled">
                    <a href="#" class="next"> <i class="flaticon-right-arrow"></i>
                    </a>
                </li>
            @endif
        </ul>
@endif
