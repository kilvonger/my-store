<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageSaver;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCatalogRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller {

    private $imageSaver;

    public function __construct(ImageSaver $imageSaver) {
        $this->imageSaver = $imageSaver;
    }

    /**
     * Показывает список всех товаров
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roots = Category::where('parent_id', 0)->get();
        $products = Product::paginate(5);
        return view('admin.product.index', compact('products', 'roots'));
    }

    /**
     * Показывает товары категории
     *
     * @return \Illuminate\Http\Response
     */
    public function category(Category $category) {
        $products = $category->products()->paginate(5);
        return view('admin.product.category', compact('category', 'products'));
    }

    /**
     * Показывает форму для создания товара
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        return view('admin.product.create', compact('items', 'brands'));
    }

    /**
     * Сохраняет новый товар в базу данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCatalogRequest $request)
    {
        $request->merge([
            'new' => $request->has('new'),
            'hit' => $request->has('hit'),
            'sale' => $request->has('sale'),
        ]);
    
        $data = $request->all();
    
        // Загружаем главное изображение
        $data['image'] = $this->imageSaver->upload($request, null, 'product');
    
        // Создаем товар
        $product = Product::create($data);
    
        // Загружаем дополнительные изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $this->imageSaver->uploadMultiple($image, 'product');
                $product->images()->create(['image' => $path]);
            }
        }
    
        return redirect()
            ->route('admin.product.show', ['product' => $product->id])
            ->with('success', 'Новый товар успешно создан');
    }

    /**
     * Показывает страницу товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product) {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Показывает форму для редактирования товара
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) {
        // все категории для возможности выбора родителя
        $items = Category::all();
        // все бренды для возмозжности выбора подходящего
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'items', 'brands'));
    }

    /**
     * Обновляет товар каталога в базе данных
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
/**
 * Обновляет товар каталога в базе данных
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\Product  $product
 * @return \Illuminate\Http\Response
 */
public function update(ProductCatalogRequest $request, Product $product)
{
    // Обработка основных данных товара
    $request->merge([
        'new' => $request->has('new'),
        'hit' => $request->has('hit'),
        'sale' => $request->has('sale'),
    ]);

    $data = $request->all();
    $data['image'] = $this->imageSaver->upload($request, $product, 'product');

    // Удаление выбранных дополнительных изображений
    if ($request->has('delete_images')) {
        foreach ($request->input('delete_images') as $imageId) {
            $image = $product->images()->find($imageId);
            if ($image) {
                $this->imageSaver->removeImage($image->image); // Удаляем файл из хранилища
                $image->delete(); // Удаляем запись из базы данных
            }
        }
    }

    // Загрузка новых дополнительных изображений
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $this->imageSaver->uploadMultiple($file, 'product');
            $product->images()->create(['image' => $path]);
        }
    }
    // Обновление данных товара
    $product->update($data);

    return redirect()
        ->route('admin.product.show', ['product' => $product->id])
        ->with('success', 'Товар был успешно обновлен');
}

    /**
     * Удаляет товар каталога из базы данных
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product) {
        $this->imageSaver->remove($product, 'product');
        $product->delete();
    
        return redirect()
            ->route('admin.product.index')
            ->with('success', 'Товар каталога успешно удален');
    }
}
