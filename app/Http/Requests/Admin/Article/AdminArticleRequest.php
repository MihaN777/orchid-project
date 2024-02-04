<?php

namespace App\Http\Requests\Admin\Article;

use Illuminate\Foundation\Http\FormRequest;

class AdminArticleRequest extends FormRequest
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
			'article.date' => ['required', 'string', 'date_format:Y-m-d'],
			'article.category_id' => ['required', 'integer', 'exists:categories,id'],
			'article.title' => ['required', 'string', 'max:100'],
			'article.text' => ['required', 'string', 'max:2000'],
			'article.is_published' => ['nullable', 'string'],
		];
	}

	public function messages()
	{
		return [
			'required' => 'Поле :attribute обязательно для заполнения',
			'integer' => 'Значение поля :attribute должно быть целым числом',
			'date_format' => 'Не корректный формат данных в поле :attribute',
			'max' => 'Превышено максимальное значение поля :attribute',
			'exists' => 'Не корректный идентификатор поля :attribute',
		];
	}

	public function attributes()
	{
		return [
			'article.id' => 'Статья',
			'article.date' => 'Дата',
			'article.category_id' => 'Категория',
			'article.title' => 'Заголовок',
			'article.text' => 'Текст',
			'article.is_published' => 'Публикация',
		];
	}
}
