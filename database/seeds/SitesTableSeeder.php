<?php

use Appstract\Multisite\Site;
use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            [
                'name' => null,
                'slug' => null,
                'url' => null,
            ],
        ];

        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}
