<?php

namespace App\Orchid\Screens\Site;

use App\Http\Requests\Admin\Site\AdminSiteUpdateRequest;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SiteEditScreen extends Screen
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
		return 'Редактирование сайта';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Button::make('Редактировать сайт')
				->icon('pencil')
				->method('update'),

			Button::make('Удалить')
				->icon('trash')
				->method('remove'),
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
					->type('file')
					->acceptedFiles('.jpg, .png, .svg')
					->title('Лого (jpg, png, svg)'),
			])
		];
	}

	public function update(Site $site, AdminSiteUpdateRequest $request)
	{
		$data = $request->validated();
		$oldLogo = $site->logo;

		if (isset($data['site']['logo'])) {
			$data['site']['logo'] = Storage::disk('public')->put(Site::LOGOS_PATH, $data['site']['logo']);
		}

		if (!$site->update($data['site'])) {
			deleteStorageFile($data['site']['logo']);
			throw ValidationException::withMessages(['error' => 'Не удалось обновить данные']);
		}

		deleteStorageFile($oldLogo);

		Toast::info('Сайт обновлен');
		return redirect()->route('platform.site.list');
	}

	public function remove(Site $site)
	{
		if (!$site->delete()) {
			throw ValidationException::withMessages(['error' => 'Не удалось удалить сайт']);
		}

		deleteStorageFile($site->logo);

		Toast::info('Сайт удален');
		return redirect()->route('platform.site.list');
	}
}
