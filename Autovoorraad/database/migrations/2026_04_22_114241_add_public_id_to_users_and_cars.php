<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->addPublicIdColumn('users');
        $this->addPublicIdColumn('autos');

        $this->backfillPublicIds('users');
        $this->backfillPublicIds('autos');

        $this->addUniqueIndexIfMissing('users', 'users_public_id_unique');
        $this->addUniqueIndexIfMissing('autos', 'autos_public_id_unique');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
                $this->dropUniqueIndexIfExists('users', 'users_public_id_unique');
                $this->dropUniqueIndexIfExists('autos', 'autos_public_id_unique');

                if (Schema::hasColumn('users', 'public_id')) {
                        Schema::table('users', function (Blueprint $table) {
                                $table->dropColumn('public_id');
                        });
                }

                if (Schema::hasColumn('autos', 'public_id')) {
                        Schema::table('autos', function (Blueprint $table) {
                                $table->dropColumn('public_id');
                        });
                }
        }

        private function addPublicIdColumn(string $tableName): void
        {
                if (! Schema::hasColumn($tableName, 'public_id')) {
                        Schema::table($tableName, function (Blueprint $table) {
                                $table->uuid('public_id')->nullable()->after('id');
                        });
                }
        }

        private function backfillPublicIds(string $tableName): void
        {
                DB::table($tableName)
                        ->select('id')
                        ->whereNull('public_id')
                        ->orWhere('public_id', '')
                        ->get()
                        ->each(function (object $row) use ($tableName): void {
                                DB::table($tableName)
                                        ->where('id', $row->id)
                                        ->update(['public_id' => (string) Str::uuid()]);
                        });
        }

        private function addUniqueIndexIfMissing(string $tableName, string $indexName): void
        {
                if (! $this->indexExists($tableName, $indexName)) {
                        Schema::table($tableName, function (Blueprint $table) use ($indexName) {
                                $table->unique('public_id', $indexName);
                        });
                }
        }

        private function dropUniqueIndexIfExists(string $tableName, string $indexName): void
        {
                if ($this->indexExists($tableName, $indexName)) {
                        Schema::table($tableName, function (Blueprint $table) use ($indexName) {
                                $table->dropUnique($indexName);
                        });
                }
        }

        private function indexExists(string $tableName, string $indexName): bool
        {
                return DB::table('information_schema.statistics')
                        ->where('table_schema', DB::getDatabaseName())
                        ->where('table_name', $tableName)
                        ->where('index_name', $indexName)
                        ->exists();
    }
};
