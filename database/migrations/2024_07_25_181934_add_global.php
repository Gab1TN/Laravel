<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTablesFromDump extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bien_immo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('libelle');
            $table->bigInteger('prix');
            $table->string('etat');
            $table->string('adresse');
            $table->string('ville');
            $table->integer('code_postal');
            $table->timestamps();
            $table->string('nom');
            $table->string('prenom');
            $table->string('localisation');
            $table->decimal('m2', 10, 2);
            $table->enum('type', ['Appartement', 'Maison', 'Terrain', 'Commerce']);
            $table->integer('nb_chambres');
            $table->integer('nb_salles_bain');
            $table->enum('parking', ['oui', 'non']);
            $table->enum('garage', ['oui', 'non']);
            $table->enum('terrain', ['oui', 'non']);
            $table->string('photo_url')->nullable();
        });

        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('favoris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bien_immo_id');
            $table->timestamps();

            $table->unique(['user_id', 'bien_immo_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('bien_immo_id')->references('id')->on('bien_immo')->onDelete('cascade');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
            $table->index(['queue']);
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->unsignedInteger('cancelled_at')->nullable();
            $table->unsignedInteger('created_at');
            $table->unsignedInteger('finished_at')->nullable();
        });

        Schema::create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('photo_bien', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_bien');
            $table->string('photo');
            $table->timestamps();

            $table->foreign('id_bien')->references('id')->on('bien_immo')->onDelete('cascade');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity');
            $table->index(['user_id']);
            $table->index(['last_activity']);
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });

        // Insert initial data
        DB::table('bien_immo')->insert([
            ['id' => 1, 'libelle' => 'Villa luxueuse vue sur mer', 'prix' => 2980000, 'etat' => 'Neuf', 'adresse' => 'Les Calanques', 'ville' => 'Le Lavandou', 'code_postal' => 83980, 'created_at' => '2024-07-14 19:28:00', 'updated_at' => '2024-07-14 19:28:00', 'nom' => 'TOURNIER', 'prenom' => 'Gabin', 'localisation' => '', 'm2' => 195.00, 'type' => 'Appartement', 'nb_chambres' => 6, 'nb_salles_bain' => 3, 'parking' => 'oui', 'garage' => 'oui', 'terrain' => 'oui', 'photo_url' => null],
            ['id' => 2, 'libelle' => 'Maison Paris 13ème', 'prix' => 690000, 'etat' => 'renové', 'adresse' => '555 rue du test', 'ville' => 'Paris', 'code_postal' => 75013, 'created_at' => '2024-07-25 15:38:52', 'updated_at' => '2024-07-25 15:38:52', 'nom' => 'DUPONT', 'prenom' => 'Marco', 'localisation' => 'Paris 13', 'm2' => 165.00, 'type' => 'Maison', 'nb_chambres' => 3, 'nb_salles_bain' => 1, 'parking' => 'oui', 'garage' => 'oui', 'terrain' => 'oui', 'photo_url' => null],
        ]);

        DB::table('favoris')->insert([
            ['id' => 1, 'user_id' => 1, 'bien_immo_id' => 1, 'created_at' => '2024-07-14 17:30:17', 'updated_at' => '2024-07-14 17:30:17'],
        ]);

        DB::table('migrations')->insert([
            ['id' => 1, 'migration' => '0001_01_01_000000_create_users_table', 'batch' => 1],
            ['id' => 2, 'migration' => '0001_01_01_000001_create_cache_table', 'batch' => 1],
            ['id' => 3, 'migration' => '0001_01_01_000002_create_jobs_table', 'batch' => 1],
            ['id' => 4, 'migration' => '2024_06_13_072158_create_bien_immo_table', 'batch' => 1],
            ['id' => 5, 'migration' => '2024_06_13_072231_create_photo_bien_table', 'batch' => 1],
            ['id' => 6, 'migration' => '2024_06_13_084010_create_favoris_table', 'batch' => 1],
            ['id' => 7, 'migration' => '2024_07_24_232945_create_annonces_table', 'batch' => 2],
            ['id' => 8, 'migration' => '2024_07_25_181837_add_photo_url_to_bien_immo_table', 'batch' => 3],
        ]);

        DB::table('photo_bien')->insert([
            ['id' => 1, 'id_bien' => 1, 'photo' => 'https://v.seloger.com/s/crop/714x540/visuels/0/9/j/r/09jroe4g51w6cmy6x853ronjwv7lvic6joqoplhnk.jpg', 'created_at' => '2024-07-14 17:27:45', 'updated_at' => '2024-07-14 17:27:45'],
        ]);

        DB::table('users')->insert([
            ['id' => 1, 'name' => 'johndoe', 'email' => 'johndoe@example.com', 'email_verified_at' => null, 'password' => '$2y$10$AI4w6FLBl9xX8O6H80rSJOcNQs1nRtNF2P7zEStiPfa.j.QENu5nW', 'remember_token' => null, 'created_at' => '2024-07-14 19:28:00', 'updated_at' => '2024-07-14 19:28:00'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_bien');
        Schema::dropIfExists('favoris');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('bien_immo');
    }
}
