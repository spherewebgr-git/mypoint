<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'title' => 'SPHERE WEB SOLUTIONS',
            'company' => 'ΚΑΡΑΓΙΑΝΝΗΣ Δ. ΣΠΥΡΙΔΩΝ',
            'business' => 'ΚΑΤΑΣΚΕΥΕΣ ΙΣΤΟΣΕΛΙΔΩΝ & ΥΠΗΡΕΣΙΕΣ ΠΡΟΩΘΗΣΗΣ',
            'email' => 'info@sphereweb.gr',
            'address' => 'ΜΠΕΡΟΒΟΥ 53, 113 63, ΚΥΨΕΛΗ, ΑΘΗΝΑ',
            'mobile' => '6940188555',
            'phone' => '2104402550',
            'vat' => '104823139',
            'doy' => 'ΙΓ ΑΘΗΝΩΝ',
            'logo' => 'sphere-logo.png',
            'invoice_logo' => 'tim-logo.jpg',
            'signature' => 'signature-image-2020.jpg',
            'mail_account' => 'alkasselouris@yahoo.gr',
        ]);
    }
}
