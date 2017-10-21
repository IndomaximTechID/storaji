<?php

use Illuminate\Database\Seeder;
use App\CompanyType;

class CompanyTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = ['Retail', 'Sales', 'Food & Beverage', 'Restaurant'];
        foreach ($list as $name) {
          CompanyType::create([
            'name' => $name
          ]);
        }
    }
}
