<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('articles', function (Blueprint $table) {
			$table->id();
			$table->date('date');
			$table->string('title');
			$table->text('text');
			$table->boolean('is_published')->default(false);
			$table->foreignId('category_id')->index()->constrained('categories')->onDelete('cascade');
			$table->foreignId('user_id')->index()->constrained('users')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('articles');
	}
};
