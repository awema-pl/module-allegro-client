
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllegroClientApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create(config('allegro-client.database.tables.allegro_client_applications'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client_id');
            $table->text('client_secret');
            $table->boolean('sandbox')->default(false);
            $table->timestamps();
        });

        Schema::table(config('allegro-client.database.tables.allegro_client_applications'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('allegro-client.database.tables.users'))
                ->onDelete('cascade');
        });

    }

    public function down()
    {
        Schema::table(config('allegro-client.database.tables.allegro_client_applications'), function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::drop(config('allegro-client.database.tables.allegro_client_applications'));
    }
}
