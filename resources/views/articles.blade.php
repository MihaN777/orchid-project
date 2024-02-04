@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/_normalize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/articles.css') }}" />
{{-- styles --}}
@endsection

@section('title', 'Example')

@section('header')
<header class="header">
	<div class="container">
		<div class="header__row">

			<div class="header__logo-col">
				<button class="header__burger-btn" id="burger">
					<span></span><span></span><span></span>
				</button>

				<a href="{{ route('home') }}" class="header__logo-link">
					<img src="{{ asset('storage/' . $category->site->logo ) }}" alt="logo"
						style="max-height: 70px; min-height: 70px;">
				</a>
			</div>

		</div>
	</div>
</header>
@endsection

@section('content')
<div class="content">
	<main class="container">

		{{-- BREAD CRUNBS --}}

		<div class="bread-crumbs__row">
			<div class="bread-crumbs__col">
				<ul class="bread-crumbs__list">

					<li class="bread-crumbs__list-item">
						<a href="{{ route('home') }}">Главная</a>
					</li>

					<li class="bread-crumbs__list-item bread-crumbs__list-item_separator">
						{{ $category->title }}
					</li>

				</ul>
				<hr class="bread-crumbs__hr-bootom" />
			</div>
		</div>

		{{-- CONTENT --}}

		<div class="category__row">
			<div class="category__col">
				<ul style="padding: 0; margin: 0;">
					@foreach ($articles as $article)
					<li style="margin-bottom: 20px;">
						<a href="{{ route('article', $article->id) }}"
							style="font-size: 25px; font-weight: 700; text-decoration: underline;">
							{{ $article->title }}
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>

		{{-- PAGINATION --}}

		<div class="nav__pagination-row">
			<div class="nav__pagination-col">
				{{ $articles->links('vendor.pagination.custom') }}
			</div>
		</div>

	</main>
</div>
{{-- content --}}
@endsection