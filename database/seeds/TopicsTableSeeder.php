<?php

use App\Models\Topic;
use App\Models\TopicCategory;
use App\Models\User;
use Illuminate\Database\Seeder;


class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $category_ids = TopicCategory::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)
            ->times(1)
            ->make()
            ->each(function ($topic, $index)
            use ($user_ids, $category_ids, $faker) {
                $topic->user_id = $faker->randomElement($user_ids);
                $topic->topic_category_id = $faker->randomElement($category_ids);
                $topic->order = $index;
            });

        Topic::insert($topics->toArray());
        $topic = Topic::first();
        $topic->addMediaFromUrl($faker->imageUrl(200, 200))->toMediaCollection('banner');
        $topic->addMediaFromUrl($faker->imageUrl(200, 200))->toMediaCollection('appendix');
        $topic->addMediaFromUrl($faker->imageUrl(200, 200))->toMediaCollection('appendix');
    }
}
