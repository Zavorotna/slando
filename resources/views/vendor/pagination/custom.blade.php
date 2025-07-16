@if ($paginator->hasPages())
    <div class="flex justify-end items-center pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a class="pagination-button cta-prev pagination-disabled" href="{{ $paginator->previousPageUrl() }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M12 14L8 10L12 6" stroke="#1E1E1E" stroke-linecap="round" />
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="separator-pag">...</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="pagination-button page current-page" href="#">
                            <span>{{ $page }}</span>
                        </a>
                    @else
                        <a class="pagination-button page" href="{{ $url }}">
                            <span>{{ $page }}</span>
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-button cta-next" href="{{ $paginator->nextPageUrl() }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M8 6L12 10L8 14" stroke="#1E1E1E" stroke-linecap="round" />
                </svg>
            </a>
        @endif
    </div>
@endif
