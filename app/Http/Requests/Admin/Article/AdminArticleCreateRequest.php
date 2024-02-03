<?php

namespace App\Http\Requests\Admin\Article;

use Illuminate\Foundation\Http\FormRequest;

class AdminArticleCreateRequest extends FormRequest
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
			'date' => ['required', 'string', 'date_format:Y-m-d'],
			'category_id' => ['required', 'integer', 'min:1', 'exists:categories,id'],
			'title' => ['required', 'string', 'max:100'],
			'text' => ['required', 'string', 'max:2000'],
			'is_published' => ['nullable', 'string'],
		];
	}

	public function messages()
	{
		return [
			'required' => 'Поле :attribute обязательно для заполнения',
			'integer' => 'Значение поля :attribute должно быть целым числом',
			'date_format' => 'Не корректный формат данных в поле :attribute',
			'max' => 'Превышено максимальное значение поля :attribute',
		];
	}

	public function attributes()
	{
		return [
			'date' => 'Дата',
			'category_id' => 'Категория',
			'title' => 'Заголовок',
			'text' => 'Текст',
			'is_published' => 'Публикация',
		];
	}
}
