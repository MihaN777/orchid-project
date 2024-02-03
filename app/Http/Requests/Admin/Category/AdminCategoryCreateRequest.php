<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryCreateRequest extends FormRequest
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
			'title' => ['required', 'string', 'max:100'],
			'is_published' => ['nullable', 'string'],
			'site_id' => ['required', 'integer', 'min:1', 'exists:sites,id'],
		];
	}

	public function messages()
	{
		return [
			'required' => 'Поле :attribute обязательно для заполнения',
			'integer' => 'Значение поля :attribute должно быть целым числом',
			'max' => 'Превышено максимальное значение поля :attribute',
			'exists' => 'Не корректный идентификатор поля :attribute',
		];
	}

	public function attributes()
	{
		return [
			'site_id' => 'Домен',
			'title' => 'Название',
			'is_published' => 'Публикация',
		];
	}
}
