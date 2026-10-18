<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Brings a legacy production database (or a fresh baseline) up to the
 * schema the modernised application relies on.
 *
 * The legacy application read several columns that its own migrations
 * never created (they were added by hand on the server). Each addition
 * below is guarded with hasColumn / hasTable so the migration is safe on
 * both a restored production dump and a fresh install.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token', 80)->nullable()->index();
            }
            if (! Schema::hasColumn('users', 'is_readonly')) {
                $table->boolean('is_readonly')->default(false);
            }
            if (! Schema::hasColumn('users', 'locale')) {
                $table->string('locale', 5)->nullable();
            }
        });

        Schema::table('partners', function (Blueprint $table) {
            if (! Schema::hasColumn('partners', 'prefix')) {
                $table->string('prefix', 20)->nullable();
            }
        });

        Schema::table('collectors', function (Blueprint $table) {
            if (! Schema::hasColumn('collectors', 'prefix')) {
                $table->string('prefix', 20)->nullable();
            }
        });

        Schema::table('application', function (Blueprint $table) {
            if (! Schema::hasColumn('application', 'reason_option')) {
                $table->text('reason_option')->nullable();
            }
            if (! Schema::hasColumn('application', 'reason_details')) {
                $table->text('reason_details')->nullable();
            }
            if (! Schema::hasColumn('application', 'year')) {
                $table->unsignedSmallInteger('year')->nullable();
            }
            if (! Schema::hasColumn('application', 'sequence')) {
                // Per-collector running number used in the application code.
                $table->unsignedInteger('sequence')->nullable();
            }
            if (! Schema::hasColumn('application', 'client_uuid')) {
                // Idempotency key supplied by the mobile client when syncing.
                $table->uuid('client_uuid')->nullable();
            }
            if (! Schema::hasColumn('application', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('application_value', function (Blueprint $table) {
            foreach (['emotional_scale', 'conduct_scale', 'hyper_activity_scale', 'peer_problem_scale', 'pro_social_scale'] as $column) {
                if (! Schema::hasColumn('application_value', $column)) {
                    $table->decimal($column, 6, 2)->nullable();
                }
            }
            if (! Schema::hasColumn('application_value', 'na_count')) {
                $table->unsignedTinyInteger('na_count')->nullable();
            }
            if (! Schema::hasColumn('application_value', 'other_nationality')) {
                $table->string('other_nationality', 100)->nullable();
            }
        });

        if (! Schema::hasTable('application_log')) {
            Schema::create('application_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('application_id')->nullable();
                $table->bigInteger('causer_id')->nullable();
                $table->text('text')->nullable();
                $table->timestamps();
            });
        } elseif (! Schema::hasColumn('application_log', 'created_at')) {
            Schema::table('application_log', function (Blueprint $table) {
                $table->timestamps();
            });
        }

        // Indexes. Names are explicit so re-running on a dump is predictable.
        $this->addIndex('application', ['code'], 'application_code_index');
        $this->addIndex('application', ['partner_id'], 'application_partner_id_index');
        $this->addIndex('application', ['collector_id'], 'application_collector_id_index');
        $this->addIndex('application', ['status'], 'application_status_index');
        $this->addIndex('application', ['year'], 'application_year_index');
        $this->addIndex('application', ['client_uuid'], 'application_client_uuid_index');
        $this->addIndex('application_value', ['application_id', 'type'], 'application_value_application_id_type_index');
        $this->addIndex('application_value', ['gouvarnate'], 'application_value_gouvarnate_index');
        $this->addIndex('collectors', ['user_id'], 'collectors_user_id_index');
        $this->addIndex('collectors', ['partner_id'], 'collectors_partner_id_index');
        $this->addIndex('partners', ['user_id'], 'partners_user_id_index');
        $this->addIndex('caza', ['gouvernate_id'], 'caza_gouvernate_id_index');
        $this->addIndex('area', ['caza_id'], 'area_caza_id_index');
        $this->addIndex('application_log', ['application_id'], 'application_log_application_id_index');

        // Legacy roles were created with guard "admin"; the application uses the "web" guard.
        DB::table('roles')->where('guard_name', 'admin')->update(['guard_name' => 'web']);
        DB::table('permissions')->where('guard_name', 'admin')->update(['guard_name' => 'web']);

        // Back-fill the year of existing applications from the pre-test date (or creation date).
        if (DB::getDriverName() === 'mysql') {
            DB::statement('UPDATE application SET year = YEAR(COALESCE(pre_test_date, created_at)) WHERE year IS NULL');
        } else {
            DB::statement("UPDATE application SET year = CAST(strftime('%Y', COALESCE(pre_test_date, created_at)) AS INTEGER) WHERE year IS NULL");
        }
    }

    public function down(): void
    {
        // Additive migration; nothing is removed on rollback to protect legacy data.
    }

    private function addIndex(string $table, array $columns, string $name): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }
        $existing = collect(Schema::getIndexes($table))->pluck('name')->all();
        if (in_array($name, $existing, true)) {
            return;
        }
        Schema::table($table, function (Blueprint $t) use ($columns, $name) {
            $t->index($columns, $name);
        });
    }
};
