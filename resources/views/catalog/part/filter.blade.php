<div class="filter-container">
    <form method="get" action="{{ $action }}" class="d-flex flex-wrap align-items-center">
        <!-- Фильтр по цене -->
        <div class="form-group mr-4">
            <label for="price-filter" class="mr-2">Цена:</label>
            <select name="price" id="price-filter" class="form-control custom-select w-auto">
                <option value="0">Выберите цену</option>
                <option value="min" @if(request()->price == 'min') selected @endif>Дешевые товары</option>
                <option value="max" @if(request()->price == 'max') selected @endif>Дорогие товары</option>
            </select>
        </div>

        <!-- Новинка -->
        <div class="form-check form-check-inline mr-3">
            <input type="checkbox" name="new" class="form-check-input" id="new-product"
                   @if(request()->has('new')) checked @endif value="yes">
            <label class="form-check-label" for="new-product">Новинка</label>
        </div>

        <!-- Лидер продаж -->
        <div class="form-check form-check-inline mr-3">
            <input type="checkbox" name="hit" class="form-check-input" id="hit-product"
                   @if(request()->has('hit')) checked @endif value="yes">
            <label class="form-check-label" for="hit-product">Лидер продаж</label>
        </div>

        <!-- Распродажа -->
        <div class="form-check form-check-inline mr-3">
            <input type="checkbox" name="sale" class="form-check-input" id="sale-product"
                   @if(request()->has('sale')) checked @endif value="yes">
            <label class="form-check-label" for="sale-product">Распродажа</label>
        </div>

        <!-- Кнопки "Фильтровать" и "Сбросить" -->
        <div class="ml-auto d-flex">
            <button type="submit" class="btn btn-primary mr-2">Фильтровать</button>
            <a href="{{ $resetUrl }}" class="btn btn-light">Сбросить</a>
        </div>
    </form>
</div>