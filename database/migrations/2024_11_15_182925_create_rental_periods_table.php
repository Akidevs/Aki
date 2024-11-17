<?php

// database/migrations/xxxx_xx_xx_create_rental_periods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalPeriodsTable extends Migration
{
    public function up()
    {
        Schema::create('rental_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('pending'); // pending, confirmed, rent_started, completed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rental_periods');
    }
}
