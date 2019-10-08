<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = factory(User::class)
            ->times(10)
            ->make();

        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        User::insert($user_array);

        $faker = app(Faker\Generator::class);

        $user = User::skip(0)->first();
        $user->name = 'Linc';
        $user->email = 'qulamj@gmail.com';
        $user->avatar = media_to_json('url', 'linc.jpg', $faker->imageUrl(200, 200));
        $user->save();
        $user->assignRole('SoftwareMaintainer');

        $user = User::skip(1)->first();
        $user->name = 'Admin';
        $user->avatar = media_to_json('url', 'admin.jpg', $faker->imageUrl(200, 200));
        $user->save();
        $user->assignRole('Administrator');

        $user = User::skip(2)->first();
        $user->name = 'Founder';
        $user->avatar = media_to_json('url', 'founder.jpg', $faker->imageUrl(200, 200));
        $user->save();
        $user->assignRole('Founder');

        $user = User::skip(3)->first();
        $user->name = 'Maintainer';
        $user->avatar = media_to_json('url', 'maintainer.jpg', $faker->imageUrl(200, 200));
        $user->save();
        $user->assignRole('Maintainer');
    }
}
