<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Category
{

    public static function getCategories($filter = [])
    {
        $query = Category::query();

        if (isset($filter) and !empty($filter['search'])) {

            $query->where(DB::raw("CONCAT_WS(' ', categories.name) "), 'LIKE', "%" . $filter['search'] . "%");
        }

        if (isset($filter) and !empty($filter['status'])) {

            $query->where('categories.status', 'LIKE', "%" . $filter['status'] . "%");
        }

        $query->orderBy('name');

        return $query;
    }
}