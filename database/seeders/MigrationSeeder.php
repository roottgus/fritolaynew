<?php

   namespace Database\Seeders;

   use Illuminate\Database\Seeder;
   use Illuminate\Support\Facades\DB;

   class MigrationSeeder extends Seeder
   {
       public function run()
       {
           DB::table('migrations')->insert([
               'migration' => '2025_04_16_044233_create_support_messages_table',
               'batch' => DB::table('migrations')->max('batch') + 1,
           ]);
       }
   }