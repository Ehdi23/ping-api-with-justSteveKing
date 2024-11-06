<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->ulid(column: 'id')->primary();

            $table->string(column: 'url');
            $table->string(column: 'content_type');

            $table->unsignedInteger(column: 'status')->default(value: Response::HTTP_OK);
            $table->unsignedInteger(column: 'header_size')->default(0);
            $table->unsignedInteger(column: 'request_size')->default(0);
            $table->unsignedInteger(column: 'redirect_count')->default(0);
            $table->unsignedInteger(column: 'http_version')->default(0);

            $table->unsignedInteger(column: 'appconnect_time')->default(0);
            $table->unsignedInteger(column: 'connect_time')->default(0);
            $table->unsignedInteger(column: 'namelookup_time')->default(0);
            $table->unsignedInteger(column: 'pretransfer_time')->default(0);
            $table->unsignedInteger(column: 'redirect_time')->default(0);
            $table->unsignedInteger(column: 'starttransfer_time')->default(0);
            $table->unsignedInteger(column: 'total_time')->default(0);
            
            $table
                ->foreignUlid(column: 'check_id')
                ->index()
                ->constrained(table: 'checks', column: 'id')
                ->cascadeOnDelete();
            
            $table->timestamp(column: 'started_at');
            $table->timestamp(column: 'finished_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
