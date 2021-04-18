<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('p_id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
            $table->boolean('can_create_user')->default(false);
            $table->boolean('can_update_user')->default(false);
            $table->boolean('can_delete_user')->default(false);
            $table->boolean('can_create_expense')->default(false);
            $table->boolean('can_update_expense')->default(false);
            $table->boolean('can_delete_expense')->default(false);
            $table->boolean('can_create_expense_category')->default(false);
            $table->boolean('can_update_expense_category')->default(false);
            $table->boolean('can_delete_expense_category')->default(false);
            $table->boolean('can_view_user_management')->default(false);
            $table->boolean('can_change_password')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index('user_id');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
