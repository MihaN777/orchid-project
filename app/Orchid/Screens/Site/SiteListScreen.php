<?php

namespace App\Orchid\Screens\Site;

use App\Http\Requests\Admin\Site\AdminSiteCreateRequest;
use App\Models\Site;
use App\Orchid\Layouts\Site\SiteListTable;
use Orchid\Attachment\File;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Upload;
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
			'site' => Site::find(1),
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
			ModalToggle::make('Редактировать сайт')->modal('editSite')->method('edit'),
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
				// Upload::make('logo')
				// 	->maxFiles(1)
				// 	// ->acceptedFiles('.jpg, .png, .svg')
				// 	->acceptedFiles('image/*')
				// 	->storage('public')
				// 	->required()
				// 	->title('Лого')
			]))->title('Создание сайта')->applyButton('Создать'),

			Layout::modal('editSite', Layout::rows([
				Input::make('site.domain')->required()->title('Домен'),
				// Input::make('site.domain')->disabled(),
			]))->title('Редактирование сайта')->applyButton('Редактировать')
		];
	}

	// public function asyncGetSite(Site $site): array
	// {
	// 	// $site->load('logo');
	// 	$site->load('attachment');
	// 	return [
	// 		'site' => $site
	// 	];
	// }

	// public function upload(AdminSiteCreateRequest $request)
	// {
	// 	$file = new File($request->file('logo'));
	// 	$attachment = $file->load();
	// 	return response()->json($attachment);
	// }

	public function create(AdminSiteCreateRequest $request)
	{
		// dd($request->toArray());

		$data = $request->validated();
		$site = Site::create($data);

		// $image = $site->attachment()->first();

		// // Get the URL of the file
		// $image->url();

		// dd($image, $image->url());

		// $site->logo()->syncWithoutDetaching(
		// 	// $request->input('logo', [])
		// 	$request->input('logo.attachment', [])
		// );

		Toast::info('Сайт создан');
	}
}
