<style>
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination li a, .pagination li span {
        padding: 6px 12px;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
    }

    .pagination li.active span {
        background-color: #0056b3;
    }

    .pagination li.disabled span {
        background-color: #ccc;
    }

    .pagination li a:hover {
        background-color: #0056b3;
    }
</style>

@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>‹</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a></li>
        @endif

        {{-- First Page --}}
        @if ($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
            <li class="disabled"><span>...</span></li>
        @endif

        {{-- Page Links --}}
        @for ($i = max(1, $paginator->currentPage() - 1); $i <= min($paginator->lastPage(), $paginator->currentPage() + 1); $i++)
            @if ($i == $paginator->currentPage())
                <li class="active"><span>{{ $i }}</span></li>
            @else
                <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor

        {{-- Last Page --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <li class="disabled"><span>...</span></li>
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">›</a></li>
        @else
            <li class="disabled"><span>›</span></li>
        @endif
    </ul>
@endif
