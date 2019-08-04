<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToTodo extends Migration
{
    // ISO order
    var $days_of_week = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    private function boolean_fields () {
        return array_map(function($value){
            return "every_".$value;
        }, $this->days_of_week) ;
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->dateTime('start_at')->nullable();
            $table->dateTime('closed_at')->nullable();
            array_map(function($name) use($table){
                $table->boolean($name)->default(false);
            }, $this->boolean_fields());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        array_map(function($value) {
            Schema::table('todos', function (Blueprint $table) use($value){
                $table->dropColumn($value);
            });
        }, array_merge(["closed_at", "start_at"], $this->boolean_fields()));
    }
}
