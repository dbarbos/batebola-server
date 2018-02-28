<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnerToGrupoTrigger extends Migration
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
        CREATE TRIGGER tr_ADD_OWNER_TO_GRUPO AFTER INSERT ON `grupos` FOR EACH ROW
            BEGIN
                INSERT INTO user_grupos (`user_id`, `grupo_id`, `aprovado`,`created_at`, `updated_at`) 
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
        DB::unprepared('DROP TRIGGER `tr_ADD_OWNER_TO_GRUPO`');
    }
}
