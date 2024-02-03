<?php

namespace App\Orchid\Screens\Site;

use App\Models\Site;
use App\Orchid\Layouts\Site\SiteListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

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
			ModalToggle::make('Создать сайт')->modal('createSite')->method('create')
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
			SiteListTable::class,
			Layout::modal('createSite', Layout::rows([
				Input::make('domain')->required(),
				Input::make('logo')->required()
			]))->title('Создание сайта')->applyButton('Создать')
		];
	}

	public function create()
	{
		Toast::info('999');
	}
}
