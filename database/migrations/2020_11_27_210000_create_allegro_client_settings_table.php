
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllegroClientSettingsTable extends Migration
{
    public function up()
    {
        Schema::create(config('allegro-client.database.tables.allegro_client_settings'), function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop(config('allegro-client.database.tables.allegro_client_settings'));
    }
}
