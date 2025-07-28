<?php

namespace App\Http\Filters;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter 
{
    public const SUBCATEGORIES = 'sub_subcategory_id';
    public const MIN_PRICE = 'min_price';
    public const MAX_PRICE = 'max_price';
    public const COLORS = 'colors';
    public const SIZES = 'sizes';

    protected function getCallbacks(): array
    {
        return [
            self::SUBCATEGORIES => [$this, 'subsubcategory'],
            self::MIN_PRICE => [$this, 'min_price'],
            self::MAX_PRICE => [$this, 'max_price'],
            self::COLORS => [$this, 'colors'],
            self::SIZES => [$this, 'sizes'],
        ];
    }

    public function subsubcategory(Builder $builder, $value)
    {
        $builder->where('sub_subcategory_id', $value);
    }

    public function min_price(Builder $builder, $value)
    {
        $builder->where('saleprice', '>=', $value);
    }

    public function max_price(Builder $builder, $value)
    {
        $builder->where('saleprice', '<=', $value);
    }

    public function colors(Builder $builder, $value)
    {
        $builder->whereHas('colors', function (Builder $query) use ($value) {
            $query->whereIn('colors.id', (array) $value);
        });
    }

    public function sizes(Builder $builder, $value)
    {
        $builder->whereHas('sizes', function (Builder $query) use ($value) {
            $query->whereIn('sizes.id', (array) $value);
        });
    }

    
}