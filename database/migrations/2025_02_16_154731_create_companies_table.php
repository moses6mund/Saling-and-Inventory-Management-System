<?php

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class);
            $table->string('company_name')->default('Pharmacy Center');
            $table->string('company_address')->default('ndungurumoses6@gmail.com');
            $table->string('company_phone')->default('+255 672313756');
            $table->string('company_email')->default('ndungurumoses6@gmail.com');
            $table->string('company_fax')->default('0672313756');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
