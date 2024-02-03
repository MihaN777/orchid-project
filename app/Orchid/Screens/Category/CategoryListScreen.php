<?php

namespace App\Orchid\Screens\Category;

use App\Http\Requests\Admin\Category\AdminCategoryCreateRequest;
use App\Models\Category;
use App\Models\Site;
use App\Orchid\Layouts\Category\CategoryListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryListScreen extends Screen
{
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable
	{
		return [
			'categories' => Category::filters()->paginate(10)
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return 'Категории';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			ModalToggle::make('Создать категорию')->modal('createCategory')->method('create')
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
			CategoryListTable::class,
			Layout::modal('createCategory', Layout::rows([
				Relation::make('site_id')->required()->fromModel(Site::class, 'domain')->title('Домен'),
				Input::make('title')->required()->title('Название'),
				CheckBox::make('is_published')->title('Публикация'),
			]))->title('Создание категории')->applyButton('Создать')
		];
	}

	public function create(AdminCategoryCreateRequest $request)
	{
		$data = $request->validated();
		$data['is_published'] = $request->boolean('is_published');

		Category::create($data);
		Toast::info('Категория создана');
	}
}
