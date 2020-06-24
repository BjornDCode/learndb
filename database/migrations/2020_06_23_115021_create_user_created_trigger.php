<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCreatedTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE FUNCTION public.store_user_created_activity()
             RETURNS trigger
             LANGUAGE plpgsql
            AS \$function\$
            BEGIN
                INSERT INTO activities (user_id, item_id, item_type, type, created_at, updated_at)
                VALUES (NEW.id, NEW.id, 'App\User', 'created', NOW(), NOW());

                RETURN NUll;
            END
            \$function\$
        ");
        DB::statement("CREATE TRIGGER user_created AFTER INSERT ON \"users\" FOR EACH ROW EXECUTE PROCEDURE store_user_created_activity();");
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
