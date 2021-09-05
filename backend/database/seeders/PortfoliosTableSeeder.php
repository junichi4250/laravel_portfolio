<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfoliosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Portfolio::create([
                'user_id'    => $i,
                'title'      => 'テスト投稿' .$i,
                'url'        => 'https://qiita.com/',
                'body'       => 'テスト投稿詳細' .$i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
