<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListTable extends Table
{
	/**
	 * Data source.
	 *
	 * The name of the key to fetch it from the query.
	 * The results of which will be elements of the table.
	 *
	 * @var string
	 */
	protected $target = 'categories';

	/**
	 * Get the table cells to be displayed.
	 *
	 * @return TD[]
	 */
	protected function columns(): iterable
	{
		return [
			TD::make('title', 'Название')->cantHide(),
			TD::make('site_id', 'Домен')->render(function (Category $category) {
				return $category->site->domain;
			}),

			TD::make('is_published', 'Публикация')->render(function (Category $category) {
				return (bool) $category->is_published ? 'Опубликована' : 'Не опубликована';
			})->sort(),

			TD::make('created_at', 'Создана')->render(function (Category $category) {
				return $category->created_at->format('d/m/Y H:i');
			}),

			TD::make('updated_at', 'Обновлена')->render(function (Category $category) {
				return $category->created_at->format('d/m/Y H:i');
			}),

			TD::make('action', 'Действия')->render(function (Category $category) {
				return ModalToggle::make('Редактировать')
					->modal('editCategory')
					->method('update')
					->modalTitle('Редактирование категории: ' . $category->title)
					->asyncParameters([
						'category' => $category->id
					]);
			})->cantHide(),
		];
	}
}
