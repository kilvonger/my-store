<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned(); // Связь с таблицей products
            $table->string('image', 255); // Путь к изображению
            $table->timestamps();

            // Внешний ключ, ссылается на поле id таблицы products
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade'); // Удаление связанных изображений при удалении товара
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}