<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role', 30)->default('customer')->after('email')->index();
            }
        });
    }

    public function down(): void
    {
        // Intentionally left as a no-op. This migration repairs installs where
        // the role column is missing, but some local databases may already have
        // it from an earlier migration filename. Rolling this back should not
        // accidentally remove an existing production access-control column.
    }
};
