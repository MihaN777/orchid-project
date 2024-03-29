<?php

namespace App\Orchid\Screens\Article;

use App\Models\Article;
use App\Orchid\Layouts\Article\ArticleListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ArticleListScreen extends Screen
{
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable
	{
		return [
			'articles' => Article::filters()->paginate(10)
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return 'Статьи';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Link::make('Создать статью')
				->icon('pencil')
				->route('platform.article.create')
		];
	}

	/**
	 * The screen's layout elements.
	 *
	 * @return \Orchid\Screen\Layout[]|string[]
	 */
	public function layout(): iterable
	{
		return [
			ArticleListLayout::class,
		];
	}
}
