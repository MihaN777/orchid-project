<?php

namespace App\Orchid\Screens\Category;

use App\Http\Requests\Admin\Category\AdminCategoryRequest;
use App\Models\Category;
use App\Models\Site;
use Illuminate\Validation\ValidationException;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CategoryEditScreen extends Screen
{
	/**
	 * @var Category
	 */
	public $category;

	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(Category $category): iterable
	{
		return [
			'category' => $category
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return $this->category->exists ? 'Редактирование категории' : 'Создание категории';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Button::make('Создать категорию')
				->icon('pencil')
				->method('createOrUpdate')
				->canSee(!$this->category->exists),

			Button::make('Редактировать категорию')
				->icon('pencil')
				->method('createOrUpdate')
				->canSee($this->category->exists),

			Button::make('Удалить')
				->icon('trash')
				->method('remove')
				->canSee($this->category->exists),
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
				Relation::make('category.site_id')->required()->fromModel(Site::class, 'domain')->title('Домен'),
				Input::make('category.title')->required()->title('Название'),
				CheckBox::make('category.is_published')->title('Публикация'),
			])
		];
	}

	public function createOrUpdate(Category $category, AdminCategoryRequest $request)
	{
		$data = $request->validated();
		$data['category']['is_published'] = isset($data['category']['is_published']) ? 1 : 0;

		if (!$category->fill($data['category'])->save()) {
			throw ValidationException::withMessages(['error' => 'Не удалось сохранить данные на категорию']);
		}

		Toast::info('Категория создана');
		return redirect()->route('platform.category.list');
	}

	public function remove(Category $category)
	{
		if (!$category->delete()) {
			throw ValidationException::withMessages(['error' => 'Не удалось удалить категорию']);
		}

		Toast::info('Категория удалена');
		return redirect()->route('platform.category.list');
	}
}
