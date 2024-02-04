<?php

namespace App\Orchid\Layouts\Category;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
	protected $target = 'categories';

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
				return Link::make(__('Edit'))
					->route('platform.category.edit', $category->id)
					->icon('bs.pencil');
			})->cantHide(),
		];
	}
}
