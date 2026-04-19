<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            CountriesTableSeeder::class,
            IndiaStatesTableSeeder::class,
            IndiaCitiesTableSeeder::class,
            UsaStatesTableSeeder::class,
            UsaCitiesTableSeeder::class,
            CanadaStatesTableSeeder::class,
            CanadaCitiesTableSeeder::class,
            AustraliaStatesTableSeeder::class,
            AustraliaCitiesTableSeeder::class,
        ]);
    }
}
