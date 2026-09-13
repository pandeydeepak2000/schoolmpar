<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use Illuminate\Support\Str;

class IndiaSchoolsSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            // PATNA
            ['name'=>'Delhi Public School Patna','city'=>'Patna','state'=>'Bihar','address'=>'Boring Road, Patna','board'=>'CBSE','fee_min'=>40000,'fee_max'=>80000],
            ['name'=>'Notre Dame Academy Patna','city'=>'Patna','state'=>'Bihar','address'=>'Ashok Nagar, Patna','board'=>'CBSE','fee_min'=>30000,'fee_max'=>55000],
            ['name'=>'St. Michael High School','city'=>'Patna','state'=>'Bihar','address'=>'Patliputra Colony, Patna','board'=>'ICSE','fee_min'=>35000,'fee_max'=>65000],
            ['name'=>'Loyola High School Patna','city'=>'Patna','state'=>'Bihar','address'=>'S.P. Verma Road, Patna','board'=>'ICSE','fee_min'=>28000,'fee_max'=>50000],
            ['name'=>'Bihar National College School','city'=>'Patna','state'=>'Bihar','address'=>'Ashok Rajpath, Patna','board'=>'State Board','fee_min'=>8000,'fee_max'=>15000],
            ['name'=>'Kendriya Vidyalaya Patna','city'=>'Patna','state'=>'Bihar','address'=>'Bailey Road, Patna','board'=>'CBSE','fee_min'=>12000,'fee_max'=>20000],
            ['name'=>'St. Joseph Convent School Patna','city'=>'Patna','state'=>'Bihar','address'=>'Rajendra Nagar, Patna','board'=>'CBSE','fee_min'=>25000,'fee_max'=>45000],
            ['name'=>'Patna Central School','city'=>'Patna','state'=>'Bihar','address'=>'Gandhi Maidan, Patna','board'=>'CBSE','fee_min'=>18000,'fee_max'=>35000],

            // DELHI
            ['name'=>'Delhi Public School R.K. Puram','city'=>'Delhi','state'=>'Delhi','address'=>'Sector 8, R.K. Puram, Delhi','board'=>'CBSE','fee_min'=>60000,'fee_max'=>120000],
            ['name'=>'Modern School Barakhamba Road','city'=>'Delhi','state'=>'Delhi','address'=>'Barakhamba Road, New Delhi','board'=>'CBSE','fee_min'=>80000,'fee_max'=>150000],
            ['name'=>'Springdales School Pusa Road','city'=>'Delhi','state'=>'Delhi','address'=>'Pusa Road, New Delhi','board'=>'CBSE','fee_min'=>55000,'fee_max'=>100000],
            ['name'=>'St. Columbas School Delhi','city'=>'Delhi','state'=>'Delhi','address'=>'Ashok Place, New Delhi','board'=>'ICSE','fee_min'=>45000,'fee_max'=>90000],
            ['name'=>'Kendriya Vidyalaya Andrews Ganj','city'=>'Delhi','state'=>'Delhi','address'=>'Andrews Ganj, New Delhi','board'=>'CBSE','fee_min'=>12000,'fee_max'=>22000],
            ['name'=>'Ryan International School Delhi','city'=>'Delhi','state'=>'Delhi','address'=>'Mayur Vihar, Delhi','board'=>'CBSE','fee_min'=>40000,'fee_max'=>75000],
            ['name'=>'Bal Bharati Public School','city'=>'Delhi','state'=>'Delhi','address'=>'Pitampura, Delhi','board'=>'CBSE','fee_min'=>35000,'fee_max'=>65000],
            ['name'=>'Sanskriti School Delhi','city'=>'Delhi','state'=>'Delhi','address'=>'Chanakyapuri, New Delhi','board'=>'CBSE','fee_min'=>90000,'fee_max'=>160000],

            // MUMBAI
            ['name'=>'Cathedral and John Connon School','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Fort, Mumbai','board'=>'ICSE','fee_min'=>100000,'fee_max'=>200000],
            ['name'=>'Dhirubhai Ambani International School','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Bandra Kurla Complex, Mumbai','board'=>'CBSE','fee_min'=>200000,'fee_max'=>400000],
            ['name'=>'Bombay Scottish School','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Mahim, Mumbai','board'=>'ICSE','fee_min'=>80000,'fee_max'=>150000],
            ['name'=>'Ryan International School Mumbai','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Malad, Mumbai','board'=>'CBSE','fee_min'=>45000,'fee_max'=>85000],
            ['name'=>'St. Marys School Mumbai','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Mazgaon, Mumbai','board'=>'ICSE','fee_min'=>60000,'fee_max'=>110000],
            ['name'=>'Podar International School','city'=>'Mumbai','state'=>'Maharashtra','address'=>'Santacruz, Mumbai','board'=>'CBSE','fee_min'=>70000,'fee_max'=>130000],
            ['name'=>'Kendriya Vidyalaya Powai','city'=>'Mumbai','state'=>'Maharashtra','address'=>'IIT Campus, Powai, Mumbai','board'=>'CBSE','fee_min'=>12000,'fee_max'=>22000],

            // BANGALORE
            ['name'=>'Bishop Cotton Boys School','city'=>'Bangalore','state'=>'Karnataka','address'=>'St. Marks Road, Bangalore','board'=>'ICSE','fee_min'=>80000,'fee_max'=>150000],
            ['name'=>'Delhi Public School Bangalore','city'=>'Bangalore','state'=>'Karnataka','address'=>'Bannerghatta Road, Bangalore','board'=>'CBSE','fee_min'=>55000,'fee_max'=>100000],
            ['name'=>'National Public School Indiranagar','city'=>'Bangalore','state'=>'Karnataka','address'=>'Indiranagar, Bangalore','board'=>'CBSE','fee_min'=>65000,'fee_max'=>120000],
            ['name'=>'Inventure Academy Bangalore','city'=>'Bangalore','state'=>'Karnataka','address'=>'Whitefield, Bangalore','board'=>'CBSE','fee_min'=>120000,'fee_max'=>220000],
            ['name'=>'Kendriya Vidyalaya Sadashivanagar','city'=>'Bangalore','state'=>'Karnataka','address'=>'Sadashivanagar, Bangalore','board'=>'CBSE','fee_min'=>12000,'fee_max'=>22000],
            ['name'=>'St. Josephs Boys High School','city'=>'Bangalore','state'=>'Karnataka','address'=>'Museum Road, Bangalore','board'=>'ICSE','fee_min'=>50000,'fee_max'=>90000],

            // CHENNAI
            ['name'=>'Chettinad Vidyashram Chennai','city'=>'Chennai','state'=>'Tamil Nadu','address'=>'R.A. Puram, Chennai','board'=>'CBSE','fee_min'=>70000,'fee_max'=>130000],
            ['name'=>'P.S. Senior Secondary School','city'=>'Chennai','state'=>'Tamil Nadu','address'=>'Mylapore, Chennai','board'=>'CBSE','fee_min'=>40000,'fee_max'=>75000],
            ['name'=>'The Hindu Senior Secondary School','city'=>'Chennai','state'=>'Tamil Nadu','address'=>'Indira Nagar, Chennai','board'=>'State Board','fee_min'=>20000,'fee_max'=>40000],
            ['name'=>'Don Bosco Matriculation School','city'=>'Chennai','state'=>'Tamil Nadu','address'=>'Egmore, Chennai','board'=>'State Board','fee_min'=>18000,'fee_max'=>35000],
            ['name'=>'Kendriya Vidyalaya IIT Chennai','city'=>'Chennai','state'=>'Tamil Nadu','address'=>'IIT Campus, Chennai','board'=>'CBSE','fee_min'=>12000,'fee_max'=>22000],

            // HYDERABAD
            ['name'=>'Hyderabad Public School','city'=>'Hyderabad','state'=>'Telangana','address'=>'Begumpet, Hyderabad','board'=>'CBSE','fee_min'=>80000,'fee_max'=>150000],
            ['name'=>'Delhi Public School Hyderabad','city'=>'Hyderabad','state'=>'Telangana','address'=>'Nacharam, Hyderabad','board'=>'CBSE','fee_min'=>55000,'fee_max'=>100000],
            ['name'=>'Oakridge International School','city'=>'Hyderabad','state'=>'Telangana','address'=>'Bachupally, Hyderabad','board'=>'CBSE','fee_min'=>120000,'fee_max'=>250000],
            ['name'=>'Kendriya Vidyalaya Begumpet','city'=>'Hyderabad','state'=>'Telangana','address'=>'Begumpet, Hyderabad','board'=>'CBSE','fee_min'=>12000,'fee_max'=>22000],
            ['name'=>'St. Anns High School Hyderabad','city'=>'Hyderabad','state'=>'Telangana','address'=>'Secunderabad, Hyderabad','board'=>'State Board','fee_min'=>25000,'fee_max'=>45000],
        ];

        $this->command->info('Importing ' . count($schools) . ' schools across 6 cities...');

        foreach ($schools as $data) {
            if (School::where('name', $data['name'])->exists()) continue;

            School::create([
                'name'             => $data['name'],
                'slug'             => Str::slug($data['name']) . '-' . strtolower(Str::random(5)),
                'city'             => $data['city'],
                'state'            => $data['state'],
                'address'          => $data['address'],
                'board'            => $data['board'],
                'medium'           => 'English',
                'class_from'       => 1,
                'class_to'         => 12,
                'fee_min'          => $data['fee_min'],
                'fee_max'          => $data['fee_max'],
                'status'           => 'active',
                'is_verified'      => rand(0,1),
                'is_featured'      => (rand(0,3) === 0),
                'admission_status' => 'open',
                'is_claimed'       => false,
                'description'      => $data['name'] . ' is a reputed ' . $data['board'] . ' school in ' . $data['city'] . ', known for academic excellence and holistic development.',
            ]);
        }

        $this->command->info('✅ Done! ' . count($schools) . ' schools imported.');
    }
}