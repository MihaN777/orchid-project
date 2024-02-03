<?php

namespace App\Orchid\Screens\Site;

use App\Http\Requests\Admin\Site\AdminSiteCreateRequest;
use App\Http\Requests\Admin\Site\AdminSiteUpdateRequest;
use App\Models\Site;
use App\Orchid\Layouts\Site\SiteListTable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
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
			'sites' => Site::paginate(10),
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
			ModalToggle::make('Создать сайт')->modal('createSite')->method('create'),
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
				Input::make('domain')->required()->title('Домен'),

				Input::make('logo')
					->type('file')
					->acceptedFiles('.jpg, .png, .svg')
					->required()
					->title('Лого'),
			]))->title('Создание сайта')->applyButton('Создать'),

			Layout::modal('editSite', Layout::rows([
				Input::make('site.id')->type('hidden'),

				Input::make('site.domain')->required()->title('Домен'),

				Input::make('site.logo')
					->type('file')
					->acceptedFiles('.jpg, .png, .svg')
					->title('Лого'),
			]))->async('asyncGetSite')->title('Редактирование сайта')->applyButton('Редактировать')
		];
	}

	public function asyncGetSite(Site $site): array
	{
		return [
			'site' => $site
		];
	}

	private function deleteLogo(?string $path)
	{
		if (
			isset($path) &&
			Storage::disk('public')->exists($path) &&
			!Storage::disk('public')->delete($path)
		) {
			Log::error(SiteListScreen::class . " [deleteLogo]: Не удалось удалить логотип сайта ({$path})");
		}
	}

	public function create(AdminSiteCreateRequest $request)
	{
		$data = $request->validated();
		$data['logo'] = Storage::disk('public')->put(Site::LOGOS_PATH, $data['logo']);

		$site = Site::create($data);

		if (!$site || !($site instanceof Site)) {
			$this->deleteLogo($data['logo']);
			throw ValidationException::withMessages(['error' => 'Не удалось записать данные']);
		} else {
			Toast::info('Сайт создан');
		}
	}

	public function update(AdminSiteUpdateRequest $request)
	{
		$data = $request->validated();
		$site = Site::find($data['site']['id']);

		if (!$site || !($site instanceof Site)) {
			throw ValidationException::withMessages(['error' => 'Не удалось найти модель данных']);
		}

		$oldLogo = $site->logo;

		if (isset($data['site']['logo'])) {
			$data['site']['logo'] = Storage::disk('public')->put(Site::LOGOS_PATH, $data['site']['logo']);
		}

		if (!$site->update($data['site'])) {
			$this->deleteLogo($data['site']['logo']);
			throw ValidationException::withMessages(['error' => 'Не удалось обновить данные']);
		} else {
			$this->deleteLogo($oldLogo);
			Toast::info('Сайт обновлен');
		}
	}
}
