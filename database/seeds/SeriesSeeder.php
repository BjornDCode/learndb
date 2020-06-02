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
            'description' => 'Learn how avoid data anomalies in a database.',
            'image' => '/images/series/database-normalisation.png',
        ]);

        factory(Series::class)->create([
            'title' => 'ER Diagrams',
            'slug' => 'er-diagrams',
            'description' => 'ER diagrams are an essential tool to create data models for applications. Learn how to create them, when to use them and all the different notation styles.',
            'image' => '/images/series/er-diagrams.png',
        ]);

        factory(Series::class)->create([
            'title' => 'PostgreSQL',
            'slug' => 'postgresql',
            'description' => 'Postgres is one of the most popular DBMS\'s. It\'s a relational database system that has powerful features like search built in.',
            'image' => '/images/series/postgresql.png',
        ]);

        factory(Series::class)->create([
            'title' => 'PHP and databases',
            'slug' => 'php-and-databases',
            'description' => 'PHP is the backend language for 80% of websites. Despite it\'s popularity it has some serious security flaws that has to be handled when interacting with a database.',
            'image' => '/images/series/php-and-databases.png',
        ]);

        factory(Series::class)->create([
            'title' => 'Relational databases',
            'slug' => 'relational-databases',
            'description' => 'Relational databases is the old-school way of creating database systems. And there is a reason for that. 50 years after it\'s invention it\'s still very solid.',
            'image' => '/images/series/relational-databases.png',
        ]);

        factory(Series::class)->create([
            'title' => 'SQL',
            'slug' => 'sql',
            'description' => 'SQL is the query language for relational databases. Whether you are using MySQL or Postgres you\'ll still need to learn SQL to retrieve stored data.',
            'image' => '/images/series/sql.png',
        ]);
    }
}
