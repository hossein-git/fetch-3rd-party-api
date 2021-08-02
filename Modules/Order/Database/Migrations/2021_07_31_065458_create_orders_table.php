<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method', 100);
            $table->string('shipping_method', 100);
            $table->foreignId('customer_id')->nullable()
                ->constrained('customers')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('company_id')->nullable()
                ->constrained('companies')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->string('type', 100);
            $table->foreignId('billing_address_id')->nullable()
                ->constrained('billing_addresses')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('shipping_address_id')->nullable()
                ->constrained('shipping_addresses')
                ->nullOnDelete()->cascadeOnUpdate();
            $table->unsignedFloat('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
