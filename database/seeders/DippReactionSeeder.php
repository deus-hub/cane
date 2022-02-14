<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DippReaction;

class DippReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'key'      => '1',
                'value'      => 'I will immediately move my holdings to cash'
            ],
            [
                'key'      => '2',
                'value'      => 'I will immediately change to more conservative strategies'
            ],
            [
                'key'      => '3',
                'value'      => 'I will wait at least three months before deciding to make any changes'
            ],
            [
                'key'      => '4',
                'value'      => 'I will immediately change to strategies that are more aggressive'
            ],
            [
                'key'      => '5',
                'value'      => 'I will immediately add to my investment and buy more equities to take advantage of the lower price'
            ]
        ];

        foreach ($datas as $data) {
            DippReaction::create($data);
        }
    }
}
