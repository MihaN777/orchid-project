<?php

namespace App\Orchid\Screens\Article;

use App\Http\Requests\Admin\Article\AdminArticleCreateRequest;
use App\Models\Article;
use App\Models\Category;
use App\Orchid\Layouts\Article\ArticleListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ArticleListScreen extends Screen
{
	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(): iterable
	{
		return [
			'articles' => Article::filters()->paginate(10)
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return 'Статьи';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			ModalToggle::make('Создать статью')->modal('createArticle')->method('create')
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
			ArticleListTable::class,
			Layout::modal('createArticle', Layout::rows([
				DateTimer::make('date')->format('Y-m-d')->required()->title('Дата'),
				Relation::make('category_id')->required()->fromModel(Category::class, 'title')->title('Категория'),
				Input::make('title')->required()->title('Заголовок'),
				TextArea::make('text')->required()->title('Текст'),
				CheckBox::make('is_published')->title('Публикация'),
			]))->title('Создание статьи')->applyButton('Создать')
		];
	}

	public function create(AdminArticleCreateRequest $request)
	{
		$data = $request->validated();
		$data['is_published'] = $request->boolean('is_published');
		$data['user_id'] = auth()->user()->id;

		Article::create($data);
		Toast::info('Статья создана');
	}
}
