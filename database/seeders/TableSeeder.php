<?php
// database/seeders/TableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create various table types for the restaurant
        $tables = [
            // Small tables (2 people)
            ['name' => 'Table 1', 'capacity' => 2, 'is_active' => true],
            ['name' => 'Table 2', 'capacity' => 2, 'is_active' => true],
            ['name' => 'Table 3', 'capacity' => 2, 'is_active' => true],
            ['name' => 'Table 4', 'capacity' => 2, 'is_active' => true],
            
            // Medium tables (4 people)
            ['name' => 'Table 5', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 6', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 7', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 8', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Table 9', 'capacity' => 4, 'is_active' => true],
            
            // Large tables (6 people)
            ['name' => 'Table 10', 'capacity' => 6, 'is_active' => true],
            ['name' => 'Table 11', 'capacity' => 6, 'is_active' => true],
            ['name' => 'Table 12', 'capacity' => 6, 'is_active' => true],
            
            // Extra large tables (8 people)
            ['name' => 'Table 13', 'capacity' => 8, 'is_active' => true],
            ['name' => 'Table 14', 'capacity' => 8, 'is_active' => true],
            
            // VIP/Private dining (10-12 people)
            ['name' => 'VIP Table 1', 'capacity' => 10, 'is_active' => true],
            ['name' => 'Private Dining Room', 'capacity' => 12, 'is_active' => true],
            
            // Some themed table names
            ['name' => 'Window Table A', 'capacity' => 2, 'is_active' => true],
            ['name' => 'Window Table B', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Patio Table 1', 'capacity' => 4, 'is_active' => true],
            ['name' => 'Patio Table 2', 'capacity' => 6, 'is_active' => true],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }

        $this->command->info('Created ' . count($tables) . ' tables successfully!');
    }
}