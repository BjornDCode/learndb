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
            'title' => 'Database Normalisation',
            'slug' => 'database-normalisation',
        ]);

        factory(Series::class)->create([
            'title' => 'ER Diagrams',
            'slug' => 'er-diagrams',
        ]);

        factory(Series::class)->create([
            'title' => 'PostgreSQL',
            'slug' => 'postgresql',
        ]);

        factory(Series::class)->create([
            'title' => 'PHP and databases',
            'slug' => 'php-and-databases',
        ]);

        factory(Series::class)->create([
            'title' => 'Relational database',
            'slug' => 'relational-databases',
        ]);

        factory(Series::class)->create([
            'title' => 'SQL',
            'slug' => 'sql',
        ]);
    }
}
