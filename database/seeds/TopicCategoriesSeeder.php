<?php

use Illuminate\Database\Seeder;

class TopicCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => '新聞',
                'description' => '提供最新、最完整的Marvel資訊',
            ],
            [
                'name' => '活動',
                'description' => '遊戲資訊、活動通知',
            ],
            [
                'name' => '攻略',
                'description' => '分享通關技巧，請保持友善，互相幫助',
            ],
            [
                'name' => '公告',
                'description' => 'FQA、遊戲指南',
            ],
        ];

        DB::table('topic_categories')->insert($categories);
    }
}
