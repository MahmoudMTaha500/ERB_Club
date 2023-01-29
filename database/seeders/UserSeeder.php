<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $super_admin = User::create([
//            "name" => 'مدير عام',
//            "email" => 'super_admin@app.com',
//            "password" => bcrypt('123'),
//        ]);
//        $super_admin->attachRole('superadministrator');
//
//        $admin = User::create([
//            "name" => 'مدير',
//            "email" => 'admin@app.com',
//            "password" => bcrypt('123'),
//        ]);
//
//        $admin->attachRole('administrator');
//        $employee = User::create([
//            "name" => 'موظف',
//            "email" => 'employee@app.com',
//            "password" => bcrypt('123'),
//        ]);
//        $admin->attachRole('user');

        $createPost = Permission::create(
            [
            'name' => 'branches-create',
            'display_name' => 'Create branch', // optional
            'description' => 'create branch', // optional
           ]);

        $createPost = Permission::create( [
                'name' => 'branches-read',
                'display_name' => 'show branch', // optional
                'description' => 'show branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'branches-update',
                'display_name' => 'update branch', // optional
                'description' => 'update branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'branches-delete',
                'display_name' => 'delete branch', // optional
                'description' => 'delete branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'sports-create',
                'display_name' => 'Create sports', // optional
                'description' => 'create sports', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'sports-read',
                'display_name' => 'read branch', // optional
                'description' => 'read branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'sports-update',
                'display_name' => 'update branch', // optional
                'description' => 'update branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'sports-delete',
                'display_name' => 'delete branch', // optional
                'description' => 'delete branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'levels-create',
                'display_name' => 'Create branch', // optional
                'description' => 'create branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'levels-update',
                'display_name' => 'update branch', // optional
                'description' => 'update branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'levels-read',
                'display_name' => 'read branch', // optional
                'description' => 'read branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'levels-delete',
                'display_name' => 'delete branch', // optional
                'description' => 'delete branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'price-list-create',
                'display_name' => 'Create branch', // optional
                'description' => 'create branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'price-list-read',
                'display_name' => 'read branch', // optional
                'description' => 'read branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'price-list-update',
                'display_name' => 'update branch', // optional
                'description' => 'update branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'price-list-delete',
                'display_name' => 'delete branch', // optional
                'description' => 'delete branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'package-create',
                'display_name' => 'Create branch', // optional
                'description' => 'create branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'package-read',
                'display_name' => 'read branch', // optional
                'description' => 'read branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'package-update',
                'display_name' => 'update branch', // optional
                'description' => 'update branch', // optional
            ]);
        $createPost = Permission::create(
            [
                'name' => 'package-delete',
                'display_name' => 'delete branch', // optional
                'description' => 'delete branch', // optional
            ]
        );





    }
}
