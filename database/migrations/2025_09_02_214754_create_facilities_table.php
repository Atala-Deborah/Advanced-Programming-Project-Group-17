<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('facilities', function (Blueprint $table) {
        $table->id('FacilityId');
        $table->string('Name');
        $table->string('Location');
        $table->text('Description')->nullable();
        $table->string('PartnerOrganization')->nullable();
        $table->string('FacilityType'); // Lab, Workshop, Testing Center
        $table->string('Capabilities')->nullable();
        $table->timestamps();

        $table->unique(['Name', 'Location']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
