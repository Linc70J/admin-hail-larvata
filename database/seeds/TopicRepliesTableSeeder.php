<?php

use App\Models\Topic;
use App\Models\TopicReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class TopicRepliesTableSeeder extends Seeder
{
    public function run()
    {
        $user_ids = User::all()->pluck('id')->toArray();
        $topic_ids = Topic::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $replies = factory(TopicReply::class)
            ->times(1000)
            ->make()
            ->each(function ($reply) use ($user_ids, $topic_ids, $faker) {
                $reply->user_id = $faker->randomElement($user_ids);
                $reply->topic_id = $faker->randomElement($topic_ids);
            });

        TopicReply::insert($replies->toArray());
    }
}
