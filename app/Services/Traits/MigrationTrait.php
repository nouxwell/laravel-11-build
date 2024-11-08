<?php

namespace App\Services\Traits;

use Illuminate\Database\Schema\Blueprint;

trait MigrationTrait
{
    public function addCommonFields(Blueprint $table): void
    {
        $table->string('entry_code')->unique();
        $table->integer('sort_order')->nullable();
        $table->boolean('soft_delete')->default(0);
        $table->timestamps();
        $table->softDeletes();
        $table->string('created_by')->nullable();
        $table->string('updated_by')->nullable();
        $table->string('deleted_by')->nullable();
    }
}
