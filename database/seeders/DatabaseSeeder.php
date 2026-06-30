<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── USERS ────────────────────────────────────────────
        $users = [
            ['full_name' => 'Dr. Abdullahi Musa',    'staff_id' => 'ADMIN001', 'email' => 'admin@mortuary.ng',      'role' => 'admin',      'password' => Hash::make('password')],
            ['full_name' => 'Fatima Sule',            'staff_id' => 'ATT001',   'email' => 'fatima@mortuary.ng',     'role' => 'attendant',  'password' => Hash::make('password')],
            ['full_name' => 'Ibrahim Kolo',           'staff_id' => 'ATT002',   'email' => 'ibrahim@mortuary.ng',    'role' => 'attendant',  'password' => Hash::make('password')],
            ['full_name' => 'Aisha Bello',            'staff_id' => 'ATT003',   'email' => 'aisha@mortuary.ng',      'role' => 'attendant',  'password' => Hash::make('password')],
            ['full_name' => 'Prof. Chukwuemeka Obi',  'staff_id' => 'MGT001',   'email' => 'mgmt@mortuary.ng',       'role' => 'management', 'password' => Hash::make('password')],
            ['full_name' => 'Ngozi Adeyemi',          'staff_id' => 'MGT002',   'email' => 'ngozi@mortuary.ng',      'role' => 'management', 'password' => Hash::make('password')],
        ];
        foreach ($users as $u) {
            DB::table('users')->insert(array_merge($u, ['status' => 'active', 'created_at' => now(), 'updated_at' => now()]));
        }

        // ── CHAMBERS ─────────────────────────────────────────
        $chambers = [
            ['name' => 'Chamber A', 'location' => 'Block A, Ground Floor', 'capacity' => 5, 'current_occupancy' => 3, 'status' => 'available'],
            ['name' => 'Chamber B', 'location' => 'Block A, Ground Floor', 'capacity' => 5, 'current_occupancy' => 5, 'status' => 'full'],
            ['name' => 'Chamber C', 'location' => 'Block B, First Floor',  'capacity' => 3, 'current_occupancy' => 1, 'status' => 'available'],
            ['name' => 'Chamber D', 'location' => 'Block B, First Floor',  'capacity' => 4, 'current_occupancy' => 0, 'status' => 'maintenance'],
            ['name' => 'Chamber E', 'location' => 'Block C, Annex',        'capacity' => 6, 'current_occupancy' => 2, 'status' => 'available'],
        ];
        foreach ($chambers as $c) {
            DB::table('chambers')->insert(array_merge($c, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ── BODIES ───────────────────────────────────────────
        $bodyData = [
            ['full_name' => 'Emeka Nwosu',       'age' => 54, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Cardiac Arrest',         'place' => 'ABUTH, Zaria',     'chamber_id' => 1, 'status' => 'in_storage', 'dod' => '2025-06-20'],
            ['full_name' => 'Hajiya Binta Umar', 'age' => 72, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Hypertensive Crisis',     'place' => 'General Hospital', 'chamber_id' => 1, 'status' => 'in_storage', 'dod' => '2025-06-18'],
            ['full_name' => 'Tunde Badmos',      'age' => 38, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Road Traffic Accident',   'place' => 'Kaduna Expressway', 'chamber_id' => 1, 'status' => 'in_storage', 'dod' => '2025-06-22'],
            ['full_name' => 'Grace Okoye',       'age' => 29, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Postpartum Haemorrhage',  'place' => 'SZU Teaching Hospital', 'chamber_id' => 2, 'status' => 'in_storage', 'dod' => '2025-06-15'],
            ['full_name' => 'Musa Ibrahim',      'age' => 61, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Diabetes Complications',  'place' => 'Home',             'chamber_id' => 2, 'status' => 'in_storage', 'dod' => '2025-06-10'],
            ['full_name' => 'Chioma Eze',        'age' => 45, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Stroke',                  'place' => 'Private Clinic',   'chamber_id' => 2, 'status' => 'in_storage', 'dod' => '2025-06-12'],
            ['full_name' => 'Aliyu Dankura',     'age' => 33, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Gunshot Wound',           'place' => 'Emergency',        'chamber_id' => 2, 'status' => 'in_storage', 'dod' => '2025-06-19'],
            ['full_name' => 'Sade Afolabi',      'age' => 55, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Kidney Failure',          'place' => 'ABUTH, Zaria',     'chamber_id' => 2, 'status' => 'in_storage', 'dod' => '2025-06-21'],
            ['full_name' => 'John Adewale',      'age' => 47, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'COVID-19 Complications',  'place' => 'Isolation Centre', 'chamber_id' => 3, 'status' => 'in_storage', 'dod' => '2025-06-08'],
            ['full_name' => 'Zainab Gani',       'age' => 19, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Drowning',                'place' => 'River Kaduna',     'chamber_id' => 5, 'status' => 'in_storage', 'dod' => '2025-06-23'],
            ['full_name' => 'Peter Obi',         'age' => 68, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Cancer',                  'place' => 'Home',             'chamber_id' => 5, 'status' => 'in_storage', 'dod' => '2025-06-05'],
            ['full_name' => 'Blessing Nweke',    'age' => 25, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Eclampsia',               'place' => 'SZU Teaching Hospital', 'chamber_id' => null, 'status' => 'released', 'dod' => '2025-05-30'],
            ['full_name' => 'Umar Kabir',        'age' => 42, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Sepsis',                  'place' => 'General Hospital', 'chamber_id' => null, 'status' => 'released', 'dod' => '2025-06-01'],
            ['full_name' => 'Amaka Okonkwo',     'age' => 58, 'sex' => 'female', 'nationality' => 'Nigerian', 'cause' => 'Hypertension',            'place' => 'Home',             'chamber_id' => null, 'status' => 'admitted',  'dod' => '2025-06-25'],
            ['full_name' => 'Yakubu Tanko',      'age' => 77, 'sex' => 'male',   'nationality' => 'Nigerian', 'cause' => 'Old Age',                 'place' => 'Home',             'chamber_id' => null, 'status' => 'admitted',  'dod' => '2025-06-24'],
        ];

        $year = 2025;
        foreach ($bodyData as $i => $b) {
            $num = str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            DB::table('bodies')->insert([
                'ref_number'      => "MTR-{$year}-{$num}",
                'full_name'       => $b['full_name'],
                'age'             => $b['age'],
                'sex'             => $b['sex'],
                'nationality'     => $b['nationality'],
                'date_of_death'   => $b['dod'],
                'time_of_death'   => '08:30:00',
                'cause_of_death'  => $b['cause'],
                'place_of_death'  => $b['place'],
                'admitted_by'     => ($i % 3) + 2, // alternate attendants (user ids 2,3,4)
                'chamber_id'      => $b['chamber_id'],
                'status'          => $b['status'],
                'created_at'      => Carbon::parse($b['dod'])->addHours(2),
                'updated_at'      => now(),
            ]);
        }

        // ── NEXT OF KINS ─────────────────────────────────────
        $kins = [
            [1, 'Chukwu Nwosu',       'Son',     '08012345678', 'NIN', 'NIN123456'],
            [2, 'Alhaji Umar Binta',   'Husband', '07023456789', 'Drivers License', 'DL987654'],
            [3, 'Mrs. Tolu Badmos',    'Wife',    '08134567890', 'Voters Card', 'VC456789'],
            [4, 'Mr. Kunle Okoye',     'Husband', '09045678901', 'NIN', 'NIN654321'],
            [5, 'Amina Ibrahim',       'Daughter','08156789012', 'Passport', 'A12345678'],
            [6, 'Chukwudi Eze',        'Brother', '07067890123', 'NIN', 'NIN111222'],
            [7, 'Hauwa Dankura',       'Mother',  '08078901234', 'Voters Card', 'VC112233'],
            [8, 'Taiwo Afolabi',       'Daughter','09089012345', 'NIN', 'NIN334455'],
            [9, 'Mrs. Adewale',        'Wife',    '08090123456', 'NIN', 'NIN556677'],
            [10,'Rabiu Gani',          'Father',  '07001234567', 'Voters Card', 'VC667788'],
            [11,'Florence Obi',        'Wife',    '08112345678', 'NIN', 'NIN889900'],
            [12,'Mrs. Okafor',         'Mother',  '07223456789', 'NIN', 'NIN001122'],
            [13,'Halima Kabir',        'Wife',    '08334567890', 'Passport', 'B98765432'],
            [14,'Emeka Okonkwo',       'Son',     '09045671234', 'Drivers License', 'DL123456'],
            [15,'Binta Tanko',         'Daughter','08056782345', 'NIN', 'NIN445566'],
        ];
        foreach ($kins as $k) {
            DB::table('next_of_kins')->insert([
                'body_id'      => $k[0],
                'full_name'    => $k[1],
                'relationship' => $k[2],
                'phone'        => $k[3],
                'id_type'      => $k[4],
                'id_number'    => $k[5],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        // ── ATTENDANCE LOGS ───────────────────────────────────
        $today = Carbon::today();
        $logs = [
            [2, $today->copy()->subDays(1)->setHour(8)->setMinute(0),  $today->copy()->subDays(1)->setHour(16)->setMinute(0),  8.00],
            [3, $today->copy()->subDays(1)->setHour(8)->setMinute(5),  $today->copy()->subDays(1)->setHour(16)->setMinute(30), 8.42],
            [4, $today->copy()->subDays(2)->setHour(8)->setMinute(0),  $today->copy()->subDays(2)->setHour(16)->setMinute(0),  8.00],
            [2, $today->copy()->subDays(2)->setHour(8)->setMinute(10), $today->copy()->subDays(2)->setHour(16)->setMinute(15), 8.08],
            [3, $today->copy()->subDays(3)->setHour(7)->setMinute(55), $today->copy()->subDays(3)->setHour(16)->setMinute(5),  8.17],
            [4, $today->copy()->subDays(3)->setHour(8)->setMinute(0),  $today->copy()->subDays(3)->setHour(15)->setMinute(30), 7.50],
            [2, $today->copy()->setHour(8)->setMinute(0),              null, null], // currently clocked in
        ];
        foreach ($logs as $l) {
            DB::table('attendance_logs')->insert([
                'staff_id'       => $l[0],
                'clock_in'       => $l[1],
                'clock_out'      => $l[2],
                'duration_hours' => $l[3],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // ── BODY RELEASES ─────────────────────────────────────
        DB::table('body_releases')->insert([
            ['body_id' => 12, 'released_by' => 1, 'kin_id' => 12, 'release_date' => '2025-06-10', 'notes' => 'Released to family after documentation.', 'created_at' => now(), 'updated_at' => now()],
            ['body_id' => 13, 'released_by' => 1, 'kin_id' => 13, 'release_date' => '2025-06-15', 'notes' => 'Burial permit verified.',                  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
