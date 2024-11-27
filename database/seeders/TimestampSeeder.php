<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimestampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hora inicial: 18:00
        $datetime = Carbon::create(2024, 11, 22, 18, 0); // 22/11/2024 18:00
        // Hora final: 00:00
        $endTime = Carbon::create(2024, 11, 23, 0, 0); // 23/11/2024 00:00

        // Insertar horarios cada 30 minutos hasta llegar a las 00:00
        while ($datetime->lessThanOrEqualTo($endTime)) {
            DB::table('schedules')->insert([
                'datetime' => $datetime->toDateTimeString(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Incrementar 1 hora
            $datetime->addHour();
        }
    }
}
