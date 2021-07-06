<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrimaryCategory extends Model
{
    public function secondaryCategories()
    {
        // 一対多
        // 紐づけることで、PrimaryCategoryクラスからSecondaryCategoryクラスを呼び出す事ができる
        return $this->hasMany(SecondaryCategory::class);
    }
}
