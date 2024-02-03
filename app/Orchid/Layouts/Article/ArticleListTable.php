<?php

namespace App\Orchid\Layouts\Article;

use App\Models\Article;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ArticleListTable extends Table
{
	/**
	 * Data source.
	 *
	 * The name of the key to fetch it from the query.
	 * The results of which will be elements of the table.
	 *
	 * @var string
	 */
	protected $target = 'articles';

	/**
	 * Get the table cells to be displayed.
	 *
	 * @return TD[]
	 */
	protected function columns(): iterable
	{
		return [
			TD::make('title', 'Название')->cantHide(),
			TD::make('text', 'Текст')->cantHide(),
			TD::make('is_published', 'Публикация')->render(function (Article $article) {
				return (bool) $article->is_published ? 'Опубликована' : 'Не опубликована';
			})->sort(),
			TD::make('created_at', 'Создана')->render(function (Article $article) {
				return $article->created_at->format('d/m/Y H:i');
			}),
			TD::make('updated_at', 'Обновлена')->render(function (Article $article) {
				return $article->created_at->format('d/m/Y H:i');
			}),
		];
	}
}
