<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        DB::statement('ALTER TABLE orders MODIFY message VARCHAR(255) DEFAULT "N/A"');
        DB::statement('ALTER TABLE orders MODIFY address VARCHAR(255) DEFAULT "N/A"');
    }

    public function down() {
        // For reverting the changes if needed
        DB::statement('ALTER TABLE orders MODIFY message VARCHAR(255)');
        DB::statement('ALTER TABLE orders MODIFY address VARCHAR(255)');
    }
};
