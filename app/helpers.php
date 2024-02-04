<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

if (!function_exists('deleteStorageFile')) {
	function deleteStorageFile(?string $path, $disk = 'public')
	{
		if (
			isset($path) &&
			Storage::disk($disk)->exists($path) &&
			!Storage::disk($disk)->delete($path)
		) {
			Log::error("[Helpers: deleteStorageFile]: Не удалось удалить файл из хранилища ({$path})");
		}
	}
}
