<?php

namespace App\Orchid\Screens\Site;

use App\Http\Requests\Admin\Site\AdminSiteCreateRequest;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SiteCreateScreen extends Screen
{
	/**
	 * @var Site
	 */
	public $site;

	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(Site $site): iterable
	{
		return [
			'site' => $site
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return 'Создание сайта';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Button::make('Создать сайт')
				->icon('pencil')
				->method('create')
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
			Layout::rows([
				Input::make('site.domain')
					->required()
					->title('Домен'),

				Input::make('site.logo')
					->required()
					->type('file')
					->acceptedFiles('.jpg, .png, .svg')
					->title('Лого (jpg, png, svg)'),
			])
		];
	}

	public function create(Site $site, AdminSiteCreateRequest $request)
	{
		$data = $request->validated();
		$data['site']['logo'] = Storage::disk('public')->put(Site::LOGOS_PATH, $data['site']['logo']);

		$site = Site::create($data['site']);

		if (!$site || !($site instanceof Site)) {
			deleteStorageFile($data['site']['logo']);
			throw ValidationException::withMessages(['error' => 'Не удалось записать данные']);
		}

		Toast::info('Сайт создан');
		return redirect()->route('platform.site.list');
	}
}
