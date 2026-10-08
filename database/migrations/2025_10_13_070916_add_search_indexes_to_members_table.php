<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb', 'pgsql'])) {
            Schema::table('members', function (Blueprint $table) {
                $table->fullText(['username', 'email_target', 'email_nick', 'libera_nick'], 'members_search_fulltext');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = Schema::getConnection();
        $driver = $connection->getDriverName();

        if (in_array($driver, ['mysql', 'mariadb', 'pgsql'])) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropFullText('members_search_fulltext');
            });
        }
    }
};
