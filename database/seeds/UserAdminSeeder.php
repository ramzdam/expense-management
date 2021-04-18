<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'p_id' => Str::uuid(),
                'name' => 'Administrator',
                'last_name' => 'Administrator',
                'work' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'p_id' => Str::uuid(),
                'name' => 'Sample',
                'last_name' => 'User',
                'work' => 'Tester',
                'email' => 'user@user.com',
                'password' => Hash::make('user'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);

        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'p_id' => Str::uuid(),
                'user_id' => 1,
                'role_id' => 1,
                'can_create_user' => true,
                'can_update_user' => true,
                'can_delete_user' => true,
                'can_create_expense' => true,
                'can_update_expense' => true,
                'can_delete_expense' => true,
                'can_create_expense_category' => true,
                'can_update_expense_category' => true,
                'can_delete_expense_category' => true,
                'can_view_user_management' => true,
                'can_change_password' => true,               
                
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'p_id' => Str::uuid(),
                'user_id' => 2,
                'role_id' => 2,
                'can_create_user' => false,
                'can_update_user' => false,
                'can_delete_user' => false,
                'can_create_expense' => true,
                'can_update_expense' => true,
                'can_delete_expense' => true,
                'can_create_expense_category' => false,
                'can_update_expense_category' => false,
                'can_delete_expense_category' => false,
                'can_view_user_management' => false,
                'can_change_password' => true,  
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
