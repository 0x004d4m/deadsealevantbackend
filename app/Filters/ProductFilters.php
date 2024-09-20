<?php

namespace App\Filters;

use Illuminate\Support\Facades\Log;

class ProductFilters extends QueryFilter
{
    public function search($value)
    {
        return $this->builder->where('title', 'LIKE', "%" . $value . "%")->orWhere('description', 'LIKE', "%" . $value . "%");
    }
    public function category_id($value)
    {
        return $this->builder->where('category_id', $value);
    }
    public function availablity($value)
    {
        if ($value == 'true') {
            return $this->builder->where('stock', '>', 0);
        } else {
            return $this->builder->where('stock', 0);
        }
    }
    public function price_from($value)
    {
        return $this->builder->where('price', '>=', $value);
    }
    public function price_to($value)
    {
        return $this->builder->where('price', '<=', $value);
    }
}
