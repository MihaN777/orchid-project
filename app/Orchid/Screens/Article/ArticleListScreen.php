<?php

namespace App\Orchid\Screens\Article;

use App\Http\Requests\Admin\Article\AdminArticleCreateRequest;
use App\Http\Requests\Admin\Article\AdminArticleUpdateRequest;
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
			'articles' => Article::filters()->paginate(10),
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
			ModalToggle::make('Создать статью')->modal('createArticle')->method('create'),
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
			]))->title('Создание статьи')->applyButton('Создать'),

			Layout::modal('editArticle', Layout::rows([
				Input::make('article.id')->type('hidden'),
				DateTimer::make('article.date')->format('Y-m-d')->required()->title('Дата'),
				Relation::make('article.category_id')->required()->fromModel(Category::class, 'title')->title('Категория'),
				Input::make('article.title')->required()->title('Заголовок'),
				TextArea::make('article.text')->required()->title('Текст'),
				CheckBox::make('article.is_published')->title('Публикация'),
			]))->async('asyncGetArticle')->title('Редактирование статьи')->applyButton('Редактировать')
		];
	}

	public function asyncGetArticle(Article $article): array
	{
		return [
			'article' => $article
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

	public function update(AdminArticleUpdateRequest $request)
	{
		$data = $request->validated();
		$data['article']['is_published'] = isset($data['article']['is_published']) ? 1 : 0;

		Article::find($request->input('article.id'))->update($data['article']);
		Toast::info('Статья обновлена');
	}
}
