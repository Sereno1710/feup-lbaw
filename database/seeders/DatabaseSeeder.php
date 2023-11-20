<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the schema file to create tables
        $schemaPath = base_path('database/schema.sql');
        $schemaSql = file_get_contents($schemaPath);

        try {
            DB::unprepared($schemaSql);
            $this->command->info('Schema seeded!');
        } catch (\Exception $e) {
            $this->command->error('Error seeding schema: ' . $e->getMessage());
        }

        // Run the populate file to insert data
        $populatePath = base_path('database/populate.sql');
        $populateSql = file_get_contents($populatePath);

        try {
            DB::unprepared($populateSql);
            $this->command->info('Data seeded!');
        } catch (\Exception $e) {
            $this->command->error('Error seeding data: ' . $e->getMessage());
        }
    }
}
