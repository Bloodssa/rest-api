<?php

use App\Models\Projects;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Projects::class, 'project_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('status', ['todo', 'in-progress', 'completed'])->default('todo');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->timestamp('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
