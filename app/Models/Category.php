<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Category extends Model
{
	use HasFactory;
	use AsSource;
	use Filterable;

	protected $table = 'categories';
	// protected $guarded = false;

	protected $fillable = [
		'title',
		'is_published',
	];

	protected $allowedSorts = [
		'is_published'
	];

	public function articles()
	{
		return $this->hasMany(Article::class, 'category_id', 'id');
	}

	public function site()
	{
		return $this->belongsTo(Site::class, 'site_id', 'id');
	}
}
