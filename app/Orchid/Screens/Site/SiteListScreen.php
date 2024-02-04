<?php

namespace App\Orchid\Screens\Site;

use App\Models\Site;
use App\Orchid\Layouts\Site\SiteListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SiteListScreen extends Screen
{
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable
	{
		return [
			'sites' => Site::paginate(10)
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return 'Сайты';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Link::make('Создать сайт')
				->icon('pencil')
				->route('platform.site.create')
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
			SiteListLayout::class,
		];
	}
}
