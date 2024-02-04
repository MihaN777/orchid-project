@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/_normalize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
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
					DEFAULT SITE LOGO
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
						Главная
					</li>

				</ul>
				<hr class="bread-crumbs__hr-bootom" />
			</div>
		</div>

		{{-- CONTENT --}}

		<div class="sites__row">
			@foreach ($categories as $category)
			<div class="sites__col">
				<div style="margin-bottom: 20px;">
					<div>Лого сайта:</div>
					<img src="{{ 'storage/' . $category->site->logo }}" alt="logo" style="width: 100%;">
				</div>
				<div>
					<a href="{{ route('articles', $category->id) }}">{{ $category->title }}</a>
				</div>
			</div>
			@endforeach
		</div>

		{{-- PAGINATION --}}

		<div class="nav__pagination-row">
			<div class="nav__pagination-col">
				{{ $categories->links('vendor.pagination.custom') }}
			</div>
		</div>

	</main>
</div>
{{-- content --}}
@endsection