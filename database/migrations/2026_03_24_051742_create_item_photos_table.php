<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        // Migrate any existing single photos to the new table
        DB::table('items')->whereNotNull('photo')->get()->each(function ($item) {
            DB::table('item_photos')->insert([
                'item_id'    => $item->id,
                'path'       => $item->photo,
                'order'      => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('description');
        });

        DB::table('item_photos')->orderBy('item_id')->orderBy('order')->get()->each(function ($photo) {
            DB::table('items')->where('id', $photo->item_id)
                ->whereNull('photo')
                ->update(['photo' => $photo->path]);
        });

        Schema::dropIfExists('item_photos');
    }
};
