<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = new \App\Post([
            'title'=>'Sample Post 1',
            'content'=>'Sample Content for Post 1'
        ]);
        $post->save();

        $post = new \App\Post([
            'title'=>'Sample Post 2',
            'content'=>'Sample Content for Post 2'
        ]);
        $post->save();
    }
}
