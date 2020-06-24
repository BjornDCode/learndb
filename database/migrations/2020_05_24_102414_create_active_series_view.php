<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveSeriesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE FUNCTION public.get_lesson_count_for_type(activity_type text) RETURNS TABLE(series_id bigint, user_id bigint, COUNT bigint) LANGUAGE PLPGSQL AS \$function\$
            BEGIN
                RETURN QUERY
                SELECT series.id AS series_id, activities.user_id, count(*) AS finished_lessons_count FROM activities
                INNER JOIN lessons ON lessons.id = activities.item_id
                INNER JOIN series ON series.id = lessons.series_id
                WHERE item_type = 'App\Lesson'
                AND activities.type = activity_type
                GROUP BY activities.user_id, series.id;
            END
            \$function\$
        ");

        DB::statement("CREATE VIEW series_lesson_count AS 
            SELECT series.id AS series_id, count(*) AS lesson_count FROM series
            INNER JOIN lessons ON lessons.series_id = series.id
            GROUP BY series.id;
        ");

        DB::statement("CREATE VIEW active_series AS
            SELECT started.series_id,
                   started.user_id
            FROM public.get_lesson_count_for_type('started') AS started
            INNER JOIN
              (SELECT *
               FROM public.get_lesson_count_for_type('finished')) AS finished ON started.user_id = finished.user_id
            AND started.series_id = finished.series_id
            INNER JOIN series_lesson_count ON series_lesson_count.series_id = started.series_id
            WHERE finished.count < series_lesson_count.lesson_count
            ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
