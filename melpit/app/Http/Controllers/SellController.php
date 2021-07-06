<?php

namespace App\Http\Controllers;

use App\Models\ItemCondition;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use Illuminate\Http\Request;

class SellController extends Controller
{
    //
    public function showSellForm()
    {
        // $categories = PrimaryCategory::orderBy('sort_no')->get();

        /**
         * N+1問題の解決。(Eager Loading)
         * 第一引数には連想配列を渡します。
         * 連想配列のキー名としてEager Loadしたいリレーションの名前を指定します。正確にはEloquent Modelでリレーションを定義しているメソッドの名前になります。
         * 値には無名関数(クロージャ)を指定します。この関数の中でEager Load時のクエリをカスタマイズできます。
         */
        $categories = PrimaryCategory::query()
            ->with([
                'secondaryCategories' => function ($query) {
                    $query->orderBy('sort_no');
                }
            ])->orderBy('sort_no')->get();

        $conditions = ItemCondition::orderBy('sort_no')->get();

        return view('sell')->with('conditions', $conditions)
            ->with('categories', $categories);
    }
}
