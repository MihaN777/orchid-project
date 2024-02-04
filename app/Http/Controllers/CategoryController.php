<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class CategoryController extends Controller
{
	public function home()
	{
		$categories = Category::query()->where('is_published', true)->paginate(10);
		return view('home', compact('categories'));
	}

	public function articles(Category $category)
	{
		$articles = $category->articles()->where('is_published', true)->paginate(10);
		return view('articles', compact('category', 'articles'));
	}

	public function article(Article $article)
	{
		return view('article', compact('article'));
	}
}
