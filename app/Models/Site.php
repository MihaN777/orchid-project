<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Site extends Model
{
	use HasFactory;
	use AsSource;
	use Attachable;

	protected $table = 'sites';

	protected $fillable = [
		'domain',
		// 'logo',
	];

	public function categories()
	{
		return $this->hasMany(Category::class, 'site_id', 'id');
	}
}
