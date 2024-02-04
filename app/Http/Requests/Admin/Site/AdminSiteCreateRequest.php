<?php

namespace App\Http\Requests\Admin\Site;

use Illuminate\Foundation\Http\FormRequest;

class AdminSiteCreateRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'site.domain' => ['required', 'string', 'max:250'],
			'site.logo' => ['required', 'file', 'image:jpg,png,svg', 'max:1024'],
		];
	}

	public function messages()
	{
		return [
			'required' => 'Поле :attribute обязательно для заполнения',
			'file' => 'В поле :attribute задан не корректный файл',
			'image' => 'В поле :attribute задано не корректное изображение',
			'site.domain.max' => 'Превышено максимальное значение поля :attribute',
			'site.logo.max' => 'Превышен размер загружаемого файла в поле :attribute',
		];
	}

	public function attributes()
	{
		return [
			'site.domain' => 'Домен',
			'site.logo' => 'Лого',
		];
	}
}
