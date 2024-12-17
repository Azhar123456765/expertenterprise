<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


use  App\Models\users;
use App\Models\seller;
use App\Models\buyer;
use App\Models\purchase_invoice;




use Faker\Factory as Faker;


class test extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Faker::create();
        for ($i=5; $i <=500; $i++) { 






                // Create a new Invoice instance
    $invoice = new buyer;

    // Assign form field values to the Invoice instance
    $invoice->buyer_id = $i;

    $invoice->company_name = $faker->name;
    $invoice->company_email = $faker->email;
   

    $invoice->credit = 1000;
    $invoice->debit = 1000;
    $invoice->buyer_type = 1;
    $invoice->city = $faker->address;
    $invoice->contact_person= $faker->name;
    $invoice->contact_person_number = $faker->address;
    $invoice->transporter = $faker->address;
    $invoice->address = $faker->address;

    // Save the Invoice instance
    $invoice->save();





        }
    }
}
