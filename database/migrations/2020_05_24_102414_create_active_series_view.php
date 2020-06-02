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
        DB::statement("CREATE VIEW active_series AS
            SELECT DISTINCT user_id, series_id
            FROM activities 
            INNER JOIN (
                SELECT *,
                (SELECT count(*) FROM lessons as irrelevant_lessons WHERE series_id = lessons.series_id) as lessons_in_series,
                (
                    SELECT count(*) FROM activities as sub_activities
                    INNER JOIN lessons as sub_lessons
                    ON sub_lessons.id = sub_activities.item_id
                    WHERE user_id = sub_activities.user_id
                    AND item_type = 'App\Lesson'
                    AND type = 'finished'
                    AND series_id = lessons.series_id
                ) as finished_lessons_in_series
                FROM lessons
            ) AS lessons
            ON activities.item_id = lessons.id 
            WHERE activities.item_type = 'App\Lesson'
            AND lessons_in_series > finished_lessons_in_series
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
