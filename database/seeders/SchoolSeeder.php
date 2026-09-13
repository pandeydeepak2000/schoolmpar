<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name'       => 'Delhi Public School Patna',
                'slug'       => 'delhi-public-school-patna',
                'city'       => 'Patna',
                'address'    => 'Boring Road, Patna, Bihar',
                'board'      => 'CBSE',
                'medium'     => 'English',
                'class_from' => 1,
                'class_to'   => 12,
                'fee_min'    => 40000,
                'fee_max'    => 80000,
                'latitude'   => 25.6093,
                'longitude'  => 85.1376,
                'status'     => 'active',      // ← YEH HONA CHAHIYE
                'is_verified'=> 1,
                'is_featured'=> 1,
            ],
            [
                'name'       => 'St. Michael High School',
                'slug'       => 'st-michael-high-school-patna',
                'city'       => 'Patna',
                'address'    => 'Patliputra Colony, Patna, Bihar',
                'board'      => 'ICSE',
                'medium'     => 'English',
                'class_from' => 1,
                'class_to'   => 10,
                'fee_min'    => 35000,
                'fee_max'    => 65000,
                'latitude'   => 25.6200,
                'longitude'  => 85.1000,
                'status'     => 'active',
                'is_verified'=> 1,
                'is_featured'=> 0,
            ],
            [
                'name'       => 'Notre Dame Academy Patna',
                'slug'       => 'notre-dame-academy-patna',
                'city'       => 'Patna',
                'address'    => 'Ashok Nagar, Patna, Bihar',
                'board'      => 'CBSE',
                'medium'     => 'English',
                'class_from' => 1,
                'class_to'   => 12,
                'fee_min'    => 30000,
                'fee_max'    => 55000,
                'latitude'   => 25.6150,
                'longitude'  => 85.1450,
                'status'     => 'active',
                'is_verified'=> 0,
                'is_featured'=> 0,
            ],
        ];

        foreach ($schools as $school) {
            School::updateOrCreate(['slug' => $school['slug']], $school);
        }
    }
}