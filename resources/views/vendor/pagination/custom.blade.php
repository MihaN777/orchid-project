@if ($paginator->hasPages())
<nav>
	<ul class="nav__pagination">

		{{-- Previous Page Link --}}
		@if ($paginator->onFirstPage())
		<li>
			<span class="nav__pagination-btn">
				<img src="{{ asset('img/contents/pagination/previous_page.svg') }}" alt="Назад" />
			</span>
		</li>
		@else
		<li>
			<a href="{{ $paginator->previousPageUrl() }}" class="nav__pagination-btn_active">
				<img src="{{ asset('img/contents/pagination/previous_page_active.svg') }}" alt="Назад" />
			</a>
		</li>
		@endif

		{{-- Pagination Elements --}}
		@foreach ($elements as $element)

		{{-- "Three Dots" Separator --}}
		@if (is_string($element))
		<li class="nav__pagination-item_serarator">{{ $element }}</li>
		@endif

		{{-- Array Of Links --}}
		@if (is_array($element))
		@foreach ($element as $page => $url)

		@if ($page == $paginator->currentPage())
		<li class="nav__pagination-item_current">{{ $page }}</li>
		@else
		<li class="nav__pagination-item"><a href="{{ $url }}" class="nav__pagination-item_link">{{ $page }}</a></li>
		@endif

		@endforeach
		@endif

		{{-- End Pagination Elements --}}
		@endforeach

		{{-- Next Page Link --}}
		@if ($paginator->hasMorePages())
		<li>
			<a href="{{ $paginator->nextPageUrl() }}" class="nav__pagination-btn_active">
				<img src="{{ asset('img/contents/pagination/next_page_active.svg') }}" alt="Вперед" />
			</a>
		</li>
		@else
		<li>
			<span class="nav__pagination-btn">
				<img src="{{ asset('img/contents/pagination/next_page.svg') }}" alt="Вперед" />
			</span>
		</li>
		@endif

	</ul>
</nav>
@endif