<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Site extends Model
{
	use HasFactory;
	use AsSource;

	const LOGOS_PATH = '/images/logos';

	protected $table = 'sites';

	protected $fillable = [
		'domain',
		'logo',
	];

	public function categories()
	{
		return $this->hasMany(Category::class, 'site_id', 'id');
	}
}
