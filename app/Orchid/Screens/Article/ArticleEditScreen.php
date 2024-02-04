<?php

namespace App\Orchid\Screens\Article;

use App\Http\Requests\Admin\Article\AdminArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Validation\ValidationException;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ArticleEditScreen extends Screen
{
	/**
	 * @var Article
	 */
	public $article;

	/**
	 * Fetch data to be displayed on the screen.
	 *
	 * @return array
	 */
	public function query(Article $article): iterable
	{
		return [
			'article' => $article
		];
	}

	/**
	 * The name of the screen displayed in the header.
	 *
	 * @return string|null
	 */
	public function name(): ?string
	{
		return $this->article->exists ? 'Редактирование статьи' : 'Создание статьи';
	}

	/**
	 * The screen's action buttons.
	 *
	 * @return \Orchid\Screen\Action[]
	 */
	public function commandBar(): iterable
	{
		return [
			Button::make('Создать статью')
				->icon('pencil')
				->method('createOrUpdate')
				->canSee(!$this->article->exists),

			Button::make('Редактировать статью')
				->icon('pencil')
				->method('createOrUpdate')
				->canSee($this->article->exists),

			Button::make('Удалить')
				->icon('trash')
				->method('remove')
				->canSee($this->article->exists),
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
				DateTimer::make('article.date')
					->format('Y-m-d')
					->required()
					->title('Дата'),

				Relation::make('article.category_id')
					->required()
					->fromModel(Category::class, 'title')
					->title('Категория'),

				Input::make('article.title')
					->required()
					->title('Заголовок'),

				TextArea::make('article.text')
					->required()
					->title('Текст')
					->rows(20),

				CheckBox::make('article.is_published')
					->title('Публикация'),
			])
		];
	}

	public function createOrUpdate(Article $article, AdminArticleRequest $request)
	{
		$data = $request->validated();
		$data['article']['is_published'] = isset($data['article']['is_published']) ? 1 : 0;
		$data['article']['user_id'] = auth()->user()->id;

		if (!$article->fill($data['article'])->save()) {
			throw ValidationException::withMessages(['error' => 'Не удалось сохранить данные на статью']);
		}

		Toast::info('Статья создана');
		return redirect()->route('platform.article.list');
	}

	public function remove(Article $article)
	{
		if (!$article->delete()) {
			throw ValidationException::withMessages(['error' => 'Не удалось удалить статью']);
		}

		Toast::info('Статья удалена');
		return redirect()->route('platform.article.list');
	}
}
