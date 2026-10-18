<?php

use App\Sdq\SdqItems;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Baseline schema of the Measuring Well-Being platform.
 *
 * Table and column names are kept identical to the legacy (Laravel 5.8)
 * application so that a production dump from the GoDaddy host can be
 * restored directly and then migrated forward. Every table is created
 * only when it does not already exist: on a restored dump this migration
 * is effectively a no-op and the "modernise" migration that follows adds
 * what is missing.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('firstname')->nullable();
                $table->string('lastname')->nullable();
                $table->string('email')->nullable()->unique();
                $table->string('phone')->nullable();
                $table->string('zone')->nullable();
                $table->text('address')->nullable();
                $table->string('fax')->nullable();
                $table->enum('is_active', ['0', '1'])->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (! Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // spatie/laravel-permission tables (same shape as the legacy install).
        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }
        if (! Schema::hasTable('model_has_permissions')) {
            Schema::create('model_has_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('permission_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_model_type_primary');
            });
        }
        if (! Schema::hasTable('model_has_roles')) {
            Schema::create('model_has_roles', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id');
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                $table->primary(['role_id', 'model_id', 'model_type'], 'model_has_roles_role_model_type_primary');
            });
        }
        if (! Schema::hasTable('role_has_permissions')) {
            Schema::create('role_has_permissions', function (Blueprint $table) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
            });
        }

        if (! Schema::hasTable('partners')) {
            Schema::create('partners', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id');
                $table->string('name')->nullable();
                $table->string('prefix')->nullable();
                $table->string('logo')->nullable();
                $table->bigInteger('max_app_per_year')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('collectors')) {
            Schema::create('collectors', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('user_id');
                $table->bigInteger('partner_id');
                $table->string('name')->nullable();
                $table->string('prefix')->nullable();
                $table->string('city')->nullable();
                $table->boolean('is_subpartner')->nullable();
                $table->string('sub_partner', 50)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('forms')) {
            Schema::create('forms', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('status')) {
            Schema::create('status', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable()->unique();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('gouvernate')) {
            Schema::create('gouvernate', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 50)->nullable();
                $table->string('arabic', 50)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('caza')) {
            Schema::create('caza', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('gouvernate_id');
                $table->string('name', 50)->nullable();
                $table->string('arabic', 50)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('area')) {
            Schema::create('area', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('caza_id');
                $table->bigInteger('gouvernate_id');
                $table->string('name', 50)->nullable();
                $table->string('arabic', 50)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('application')) {
            Schema::create('application', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 50)->nullable();
                $table->timestamp('pre_test_date')->nullable();
                $table->timestamp('post_test_date')->nullable();
                $table->bigInteger('partner_id')->nullable();
                $table->bigInteger('collector_id')->nullable();
                $table->string('language', 50)->nullable();
                $table->bigInteger('status')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('application_value')) {
            Schema::create('application_value', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('application_id');
                $table->enum('type', ['pre_test', 'post_test'])->nullable();
                $table->string('category', 50)->nullable();
                $table->string('child_code', 50)->nullable();
                $table->string('gouvarnate', 50)->nullable();
                $table->string('caza', 50)->nullable();
                $table->string('agency_name', 50)->nullable();
                $table->string('form')->nullable();
                $table->string('donor_name', 50)->nullable();
                $table->string('interview_date', 50)->nullable();
                $table->string('interviewers_name', 50)->nullable();
                $table->string('age', 50)->nullable();
                $table->string('gender', 50)->nullable();
                $table->string('nationality', 50)->nullable();
                $table->string('area', 50)->nullable();
                $table->string('gateway_type', 50)->nullable();
                $table->string('p_code', 50)->nullable();
                $table->string('latitude', 50)->nullable();
                $table->string('longitude', 50)->nullable();
                $table->string('altitude', 50)->nullable();
                $table->string('accuracy', 50)->nullable();
                $table->string('may_i_start_now', 50)->nullable();
                foreach (SdqItems::all() as $item) {
                    $table->string($item, 50)->nullable();
                }
                $table->string('number_of_hours_that_the_child_attended')->nullable();
                $table->string('total_number_of_hours_in_your_program', 50)->nullable();
                $table->string('dropout_reason', 100)->nullable();
                $table->string('justify_the_dropout_reason')->nullable();
                $table->text('do_the_child_receive_any_other_child_protection_services')->nullable();
                $table->text('comment')->nullable();
                $table->string('score')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        foreach ([
            'application_value', 'application', 'area', 'caza', 'gouvernate', 'status', 'forms',
            'collectors', 'partners', 'role_has_permissions', 'model_has_roles', 'model_has_permissions',
            'roles', 'permissions', 'sessions', 'password_reset_tokens', 'users',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
