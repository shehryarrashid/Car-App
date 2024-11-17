<x-layout title="Garage">

<?php 
        // Assuming $cars is a paginated result from Eloquent
        $currentPage = $cars->currentPage();
        $totalPages = $cars->lastPage();
        $cars->appends(['search' => request()->input('search')])->links();
?>


<div class="car-list">
    <h1 class="car-list-title">My Cars</h1>

    @if(!empty(request('search')))
        <!-- Results Comment Box -->
        <div class="results-comment">
            @if($cars->total() > 0)
                <p>{{ $cars->firstItem() }} - {{ $cars->lastItem() }} of over {{ $cars->total() }} results for {{ request('search') }}</p>
            @else
                <p>No cars found matching your search.</p>
            @endif
        </div>
    @else
        <p>Total Cars: {{ $cars->total() }}</p>
    @endif 

    @foreach ($cars as $car)
    <div class="car-item">
        <span class="car-name">{{$car->make}} {{$car->model}}</span>
        <a href="/cars/{{$car->id}}" class="view-button">View</a>
    </div>
    @endforeach
    
    <div class="pagination-container">

    <!-- Previous Button -->
    <a href="{{ $currentPage > 1 ? url()->current() . '?page=' . ($currentPage - 1) . '&search=' . request('search') : '#' }}"
       class="pagination-button {{ $currentPage === 1 ? 'disabled' : '' }}">
        &laquo; Previous
    </a>

    <!-- Page Numbers -->
    <div class="page-numbers">
        @if($totalPages > 7)
            <!-- Show first page, ellipsis, and current page with surrounding pages -->
            @if($currentPage > 3)
                <a href="{{ url()->current() . '?page=1&search=' . request('search') }}" class="pagination-link">1</a>
            @endif
            @if($currentPage > 4)
                <span class="ellipsis">...</span>
            @endif
            @for ($page = max(1, $currentPage - 2); $page <= min($totalPages, $currentPage + 2); $page++)
                <a href="{{ url()->current() . '?page=' . $page . '&search=' . request('search') }}" class="pagination-link {{ $page == $currentPage ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endfor
            @if($currentPage < $totalPages - 3)
                <span class="ellipsis">...</span>
            @endif
            @if($currentPage < $totalPages - 2)
                <a href="{{ url()->current() . '?page=' . $totalPages . '&search=' . request('search') }}" class="pagination-link">{{ $totalPages }}</a>
            @endif
        @else
            <!-- Show all pages if there are fewer than 7 -->
            @for ($page = 1; $page <= $totalPages; $page++)
                <a href="{{ url()->current() . '?page=' . $page . '&search=' . request('search') }}" class="pagination-link {{ $page == $currentPage ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endfor
        @endif
    </div>

    <!-- Next Button -->
    <a href="{{ $currentPage < $totalPages ? url()->current() . '?page=' . ($currentPage + 1) . '&search=' . request('search') : '#' }}"
       class="pagination-button {{ $currentPage === $totalPages ? 'disabled' : '' }}">
        Next &raquo;
    </a>
</div>

</div>
</x-layout>