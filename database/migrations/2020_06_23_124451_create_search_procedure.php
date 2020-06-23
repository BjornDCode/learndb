<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE FUNCTION public.search_series_and_lessons(search_query text)
 RETURNS TABLE(id bigint, title character varying, slug character varying, type text, parent_slug character varying)
 LANGUAGE plpgsql
AS \$function\$
BEGIN
    RETURN QUERY
    SELECT lessons.id, lessons.title, lessons.slug, 'lesson' AS type, series.slug as parent_slug FROM lessons
    INNER JOIN series
    ON lessons.series_id = series.id
    WHERE to_tsvector(lessons.title) @@ to_tsquery(search_query)
    UNION ALL 
    SELECT series.id, series.title, series.slug, 'series' AS type, '' as parent_slug FROM series
    WHERE to_tsvector(series.title) @@ to_tsquery(search_query)
END
\$function\$
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
