@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/_normalize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/article.css') }}" />
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
					<img src="{{ asset('storage/' . $article->category->site->logo ) }}" alt="logo"
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
						<a href="{{ route('articles', $article->category->id) }}">
							{{ $article->category->title }}
						</a>
					</li>

					<li class="bread-crumbs__list-item bread-crumbs__list-item_separator">
						{{ $article->title }}
					</li>

				</ul>
				<hr class="bread-crumbs__hr-bootom" />
			</div>
		</div>

		{{-- CONTENT --}}

		<div class="article__row">
			<div class="article__col" style="display: flex; flex-direction: column;">
				<div style="font-size: 20px;">
					{{ $article->category->title }}
				</div>

				<div style="font-size: 15px; margin-top: 10px;">
					{{ (now())->parse($article->date)->format('d/m/Y') }}
				</div>

				<div style="font-size: 35px; margin-top: 50px;">
					{{ $article->title }}
				</div>

				<p style="font-size: 18px; margin-top: 10px;">
					{{ $article->text }}
				</p>
			</div>
		</div>

	</main>
</div>
{{-- content --}}
@endsection