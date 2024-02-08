<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DefaultCatergoryTableSeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Tabung Hari Jumaat', 'color' => '#00AABB', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Tabung Subuh', 'color' => '#00AABB', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Tabung Harian', 'color' => '#00AABB', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Kemasukan Infaq Lain-lain', 'color' => '#00AABB', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Gaji AJK Masjid', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_INTERNAL, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Bayaran Penghargaan Penceramah Jemputan', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Perbelanjaan Program', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Perbelanjaan Iftar/Sahur', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Bil Air', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Bil Elektrik', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Bil Internet', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Perbelanjaan Lain-lain', 'color' => '#F16867', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
        Category::create(['name' => 'Pengambilan Di Bank', 'color' => '#00AABB', 'report_visibility_code' => Category::REPORT_VISIBILITY_PUBLIC, 'creator_id' => 1, 'book_id' => 1]);
    }
}
