<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    // 出品中
    const STATE_SELLING = 'selling';

    // 購入済み
    const STATE_BOUGHT = 'bought';

    // 商品の購入日時
    // castsフィールドを使うことで、カラムの値を取り出す際に、データ型を変換させることができます。
    protected $casts = [
        'bought_at' => 'datetime',
    ];

    public function secondaryCategory()
    {
        return $this->belongsTo(SecondaryCategory::class);
    }

    public function seller()
    {
        return $this->BelongsTo(User::class, 'seller_id');
    }

    public function condition()
    {
        return $this->BelongsTo(ItemCondition::class, 'item_condition_id');
    }

    public function getIsStateSellingAttribute()
    {
        return $this->state === self::STATE_SELLING;
    }

    public function getIsStateBoughtAttribute()
    {
        return $this->state === self::STATE_BOUGHT;
    }
}
