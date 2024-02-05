<?php

namespace App\Orchid\Layouts\Site;

use App\Models\Site;
use App\Orchid\Tags\Tag;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SiteListLayout extends Table
{
	protected $target = 'sites';

	/**
	 * Get the table cells to be displayed.
	 *
	 * @return TD[]
	 */
	protected function columns(): iterable
	{
		return [
			TD::make('domain', 'Домен')->cantHide(),

			TD::make('logo', 'Лого')->render(function (Site $site) {
				return Tag::IMG(asset("storage/{$site->logo}"), 'width:200px;');
			}),

			TD::make('created_at', 'Создан')->render(function (Site $site) {
				return $site->created_at->format('d/m/Y H:i');
			}),

			TD::make('updated_at', 'Обновлен')->render(function (Site $site) {
				return $site->created_at->format('d/m/Y H:i');
			}),

			TD::make('action', 'Действия')->render(function (Site $site) {
				return Link::make(__('Edit'))
					->route('platform.site.edit', $site->id)
					->icon('bs.pencil');
			})->cantHide(),
		];
	}
}
