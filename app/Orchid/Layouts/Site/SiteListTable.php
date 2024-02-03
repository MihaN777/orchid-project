<?php

namespace App\Orchid\Layouts\Site;

use App\Models\Site;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SiteListTable extends Table
{
	/**
	 * Data source.
	 *
	 * The name of the key to fetch it from the query.
	 * The results of which will be elements of the table.
	 *
	 * @var string
	 */
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
				// FIXME :)
				$img = asset("storage/{$site->logo}");
				return "<img src=\"{$img}\" style=\"width:200px;\">";
			}),

			TD::make('created_at', 'Создан')->render(function (Site $site) {
				return $site->created_at->format('d/m/Y H:i');
			}),

			TD::make('updated_at', 'Обновлен')->render(function (Site $site) {
				return $site->created_at->format('d/m/Y H:i');
			}),

			TD::make('action', 'Действия')->render(function (Site $site) {
				return ModalToggle::make('Редактировать')
					->modal('editSite')
					->method('update')
					->modalTitle('Редактирование сайта: ' . $site->domain)
					->asyncParameters([
						'site' => $site->id
					]);
			})->cantHide(),
		];
	}
}
