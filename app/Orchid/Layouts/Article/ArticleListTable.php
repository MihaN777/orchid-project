<?php

namespace App\Orchid\Layouts\Article;

use App\Models\Article;
use Illuminate\Support\Carbon;
use Orchid\Screen\Actions\ModalToggle;
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

			TD::make('date', 'Дата')->render(function (Article $article) {
				return (new Carbon($article->date))->format('d/m/Y');
			}),

			TD::make('text', 'Текст')->defaultHidden(),

			TD::make('is_published', 'Публикация')->render(function (Article $article) {
				return (bool) $article->is_published ? 'Опубликована' : 'Не опубликована';
			})->sort(),

			TD::make('category_id', 'Категория')->render(function (Article $article) {
				return $article->category->title;
			}),

			TD::make('user_id', 'Пользователь')->render(function (Article $article) {
				return $article->user->name;
			}),

			TD::make('created_at', 'Создана')->render(function (Article $article) {
				return $article->created_at->format('d/m/Y H:i');
			}),

			TD::make('updated_at', 'Обновлена')->render(function (Article $article) {
				return $article->created_at->format('d/m/Y H:i');
			}),

			TD::make('action', 'Действия')->render(function (Article $article) {
				return ModalToggle::make('Редактировать')
					->modal('editArticle')
					->method('update')
					->modalTitle('Редактирование статьи: ' . $article->title)
					->asyncParameters([
						'article' => $article->id
					]);
			})->cantHide(),
		];
	}
}
