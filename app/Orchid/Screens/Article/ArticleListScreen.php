<?php

namespace App\Orchid\Screens\Article;

use App\Models\Article;
use App\Orchid\Layouts\Article\ArticleListTable;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
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
				Input::make('title')->required(),
				TextArea::make('text')->required(),
				// DateTimer::make('date')->format('Y-m-d')
			]))->title('Создание статьи')->applyButton('Создать')
		];
	}

	public function create()
	{
		Toast::info('888');
	}
}
