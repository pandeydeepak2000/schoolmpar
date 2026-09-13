<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\Admission;
use App\Models\Payment;
use App\Models\VisitBooking;
use App\Models\ActivityLog;
use Carbon\Carbon;

class PlatformDataSeeder extends Seeder
{
    public function run(): void
    {
        $parent = User::where('email', 'parent@schoolmapr.com')->first();
        if (!$parent) {
            $parent = User::firstOrCreate(
                ['email' => 'parent@schoolmapr.com'],
                ['name' => 'Amit Sharma', 'password' => bcrypt('password'), 'phone' => '+91 9876543212']
            );
            if (method_exists($parent, 'assignRole')) {
                $parent->assignRole('parent');
            }
        }

        $schools = School::take(6)->get();
        if ($schools->isEmpty()) {
            return;
        }

        $students = [
            ['Aarav Sharma', '2016-04-12', 'male', 'Class 4', 'Patna Central School', 'Class 3', 88.5],
            ['Ananya Verma', '2014-08-25', 'female', 'Class 6', 'Loyola High School Patna', 'Class 5', 92.0],
            ['Rohan Kumar', '2012-01-15', 'male', 'Class 8', 'St. Michael\'s High School', 'Class 7', 84.2],
            ['Ishita Singh', '2011-11-03', 'female', 'Class 9', 'Delhi Public School Patna', 'Class 8', 95.1],
            ['Aditya Raj', '2010-06-19', 'male', 'Class 10', 'Notre Dame Academy Patna', 'Class 9', 79.4],
            ['Priya Kumari', '2009-09-30', 'female', 'Class 11', 'DAV Public School BSEB', 'Class 10', 91.8],
        ];

        // 1. Create Payments & Admissions
        foreach ($students as $idx => $s) {
            $school = $schools[$idx % $schools->count()];

            $payment = Payment::create([
                'user_id'             => $parent->id,
                'school_id'           => $school->id,
                'razorpay_order_id'   => 'order_PATNA_' . rand(100000, 999999),
                'razorpay_payment_id' => 'pay_SM_' . strtoupper(substr(md5(uniqid()), 0, 10)),
                'amount'              => rand(500, 2500),
                'type'                => 'registration_fee',
                'status'              => 'success',
                'created_at'          => Carbon::now()->subDays(rand(1, 14)),
            ]);

            $statusArr = ['pending', 'reviewing', 'approved', 'approved'];
            $status = $statusArr[$idx % count($statusArr)];

            Admission::create([
                'user_id'             => $parent->id,
                'school_id'           => $school->id,
                'payment_id'          => $payment->id,
                'student_name'        => $s[0],
                'student_dob'         => $s[1],
                'student_gender'      => $s[2],
                'class_applying'      => $s[3],
                'parent_name'         => $parent->name,
                'parent_phone'        => $parent->phone ?? '+91 9876543212',
                'parent_email'        => $parent->email,
                'address'             => 'Flat 402, Boring Road, Near Alankar Place, Patna, Bihar - 800001',
                'previous_school'     => $s[4],
                'previous_class'      => $s[5],
                'previous_percentage' => $s[6],
                'status'              => $status,
                'created_at'          => Carbon::now()->subDays(rand(1, 14)),
            ]);
        }

        // 2. Create Campus Visits
        $visitTimes = ['10:00:00', '11:30:00', '14:00:00', '15:30:00'];
        $visitStatuses = ['confirmed', 'completed', 'pending', 'confirmed'];

        foreach ($schools as $i => $sc) {
            VisitBooking::create([
                'user_id'        => $parent->id,
                'school_id'      => $sc->id,
                'visit_date'     => Carbon::now()->addDays($i + 1)->format('Y-m-d'),
                'visit_time'     => $visitTimes[$i % count($visitTimes)],
                'visitor_name'   => 'Amit Sharma',
                'visitor_phone'  => '+91 9876543212',
                'notes'          => 'Interested in science laboratories, smart classrooms and transport route from Kankarbagh.',
                'status'         => $visitStatuses[$i % count($visitStatuses)],
                'created_at'     => Carbon::now()->subDays(rand(1, 7)),
            ]);
        }

        // 3. Create Activity Audit Logs
        $logs = [
            ['School Verified', 'Admin verified and activated profile for Don Bosco Academy, Patna', 'App\Models\School', $schools[0]->id, 'Admin', 'Super Admin'],
            ['Admission Submitted', 'Application submitted for Aarav Sharma for Class 4 at ' . $schools[0]->name, 'App\Models\Admission', 1, 'Parent', 'Amit Sharma'],
            ['Payment Received', 'Registration fee of ₹1,500 successfully processed via Razorpay UPI', 'App\Models\Payment', 1, 'Parent', 'Amit Sharma'],
            ['Visit Scheduled', 'Campus counselling visit confirmed for ' . $schools[1]->name . ' on upcoming Saturday', 'App\Models\VisitBooking', 1, 'Parent', 'Amit Sharma'],
            ['School Updated', 'Fee structure and 5-slot campus gallery updated for ' . $schools[1]->name, 'App\Models\School', $schools[1]->id, 'Admin', 'Super Admin'],
            ['User Auth Login', 'Successful Super Admin authentication from Patna District console IP', null, null, 'Admin', 'Super Admin'],
            ['Admission Approved', 'Admission application for Ananya Verma (Class 6) reviewed and approved', 'App\Models\Admission', 2, 'Admin', 'Super Admin'],
            ['Lead Generated', 'Direct enquiry submitted for Class 9 admission open cycle 2026-27', 'App\Models\Enquiry', 1, 'Parent', 'Amit Sharma'],
        ];

        foreach ($logs as $k => $l) {
            ActivityLog::create([
                'user_id'     => $parent->id,
                'user_name'   => $l[5],
                'role'        => $l[4],
                'action'      => $l[0],
                'description' => $l[1],
                'entity_type' => $l[2],
                'entity_id'   => $l[3],
                'ip_address'  => '122.161.48.' . rand(10, 99),
                'created_at'  => Carbon::now()->subHours($k * 3 + 1),
            ]);
        }
    }
}
