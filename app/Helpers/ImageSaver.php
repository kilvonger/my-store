<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageSaver
{
    /**
     * Сохраняет изображение при создании или редактировании категории,
     * бренда или товара; создает два уменьшенных изображения.
     *
     * @param \Illuminate\Http\Request $request — объект HTTP-запроса
     * @param \App\Models\Item|null $item — модель категории, бренда или товара
     * @param string $dir — директория, куда будем сохранять изображение
     * @return string|null — имя файла изображения для сохранения в БД
     */
    public function upload($request, $item, $dir)
    {
        $name = $item->image ?? null;

        // Если нужно удалить изображение
        if ($item && $request->remove) {
            $this->remove($item, $dir);
            $name = null;
        }

        // Если загружено новое изображение
        $source = $request->file('image');
        if ($source) {
            // Удаляем старое изображение, если оно существует
            if ($item && $item->image) {
                $this->remove($item, $dir);
            }

            $ext = $source->extension();
            // Сохраняем исходное изображение
            $path = $source->store('catalog/' . $dir . '/source', 'public');
            $path = Storage::disk('public')->path($path); // Абсолютный путь
            $name = basename($path); // Имя файла

            // Создаем уменьшенные копии изображения
            $this->resize($path, 'catalog/' . $dir . '/image/', 586, 500, $ext); // Большая копия
            $this->resize($path, 'catalog/' . $dir . '/thumb/', 300, 150, $ext); // Маленькая копия
        }

        return $name;
    }

    /**
     * Загружает несколько изображений.
     *
     * @param \Illuminate\Http\UploadedFile $file — загруженный файл
     * @param string $type — тип (например, 'product')
     * @return string — путь к файлу для сохранения в базе данных
     */
    public function uploadMultiple($file, $type)
    {
        // Сохраняем файл в папку storage/app/public/$type/source
        $path = $file->store('public/' . $type);

        // Возвращаем путь к файлу для использования в базе данных
        return str_replace('public/', 'storage/', $path);
    }

    /**
     * Создает уменьшенную копию изображения.
     *
     * @param string $src — путь к исходному изображению
     * @param string $dst — куда сохранять уменьшенное изображение
     * @param int $width — ширина в пикселях
     * @param int $height — высота в пикселях
     * @param string $ext — расширение уменьшенного изображения
     */
    private function resize($src, $dst, $width, $height, $ext)
    {
        // Создаем уменьшенное изображение width x height, качество 100%
        $image = Image::make($src)
            ->heighten($height)
            ->resizeCanvas($width, $height, 'center', false, 'eeeeee')
            ->encode($ext, 100);

        // Сохраняем это изображение под тем же именем, что исходное
        $name = basename($src);
        Storage::disk('public')->put($dst . $name, $image);
        $image->destroy();
    }

    /**
     * Удаляет изображение при удалении категории, бренда или товара.
     *
     * @param \App\Models\Item $item — модель категории, бренда или товара
     * @param string $dir — директория, в которой находится изображение
     */
    public function remove($item, $dir)
    {
        $old = $item->image;
        if ($old) {
            Storage::disk('public')->delete('catalog/' . $dir . '/source/' . $old);
            Storage::disk('public')->delete('catalog/' . $dir . '/image/' . $old);
            Storage::disk('public')->delete('catalog/' . $dir . '/thumb/' . $old);
        }
    }

    /**
     * Удаляет одно дополнительное изображение.
     *
     * @param string $imagePath — путь к изображению
     */
    public function removeImage($imagePath)
    {
        $path = str_replace('storage/', 'public/', $imagePath);
        Storage::delete($path);
    }
}