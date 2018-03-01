<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerToGroupTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('
        CREATE TRIGGER tr_ADD_OWNER_TO_GROUP AFTER INSERT ON `groups` FOR EACH ROW
            BEGIN
                INSERT INTO user_groups (`user_id`, `group_id`, `approved`,`created_at`, `updated_at`) 
                VALUES (NEW.user_id, NEW.id, 1, NOW(), NOW());
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared('DROP TRIGGER `tr_ADD_OWNER_TO_GROUP`');
    }
}
