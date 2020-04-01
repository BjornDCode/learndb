<?php

use App\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Series::class)->create([
            'title' => 'Introduction to databases',
            'slug' => 'introduction-to-databases',
        ]);

        factory(Series::class)->create([
            'title' => 'Database Normalisation',
            'slug' => 'database-normalisation',
        ]);

        factory(Series::class)->create([
            'title' => 'Relational Databases',
            'slug' => 'relational-databases',
        ]);

        factory(Series::class)->create([
            'title' => 'Graph Databases',
            'slug' => 'graph-databases',
        ]);

        factory(Series::class)->create([
            'title' => 'Advanced Data Modelling',
            'slug' => 'advanced-data-modelling',
        ]);
    }
}
