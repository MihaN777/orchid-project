<?php

namespace App\Orchid\Layouts\Site;

use App\Models\Site;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SiteListLayout extends Table
{
	protected $target = 'sites';

	protected static function makeImage(?string $path, int $width = 200): string
	{
		$img = asset("storage/{$path}");
		return "<img src=\"{$img}\" style=\"width:{$width}px;\">";
	}

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
				return self::makeImage($site->logo);
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
