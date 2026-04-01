<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => '食費']);
        Category::create(['name' => '外食']);
        Category::create(['name' => 'その他食費']);
        Category::create(['name' => '日用品']);
        Category::create(['name' => '交通費']);
        Category::create(['name' => '水道代']);
        Category::create(['name' => '電気代']);
        Category::create(['name' => 'ガス代']);
        Category::create(['name' => '旅行']);
        Category::create(['name' => '衣服']);
        Category::create(['name' => '美容院']);
        Category::create(['name' => '書籍・学習']);
    }
}