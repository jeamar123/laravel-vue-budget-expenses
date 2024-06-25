<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        define('SUPER_ADMIN_ID', '1ee1c980-6116-67dc-afb4-0242ac120006');
        define('ADMIN_ID', '1ee1c980-6116-68dc-afb4-0242ac120006');
        define('USER_ID', '1ee1c980-6116-67dc-afb5-0242ac120006');

        define('CATEGORY_ID', '1ee1c980-6116-67dc-afb6-0242ac120006');

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            TransactionSeeder::class,
            CategorySeeder::class,
            AccountSeeder::class,
        ]);
    }
}
