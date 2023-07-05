<?php

use Illuminate\Database\Seeder;
use App\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUser();
    }

    private function createUser ()
    {
        $master                 = new User();
        $master->username       = 'admin';
        $master->name           = 'Admin';
        $master->email          = 'Admin@gmail.com';
        $master->renter_id      = '1';
        $master->branch_id      = null;
        $master->address        = 'Davao city';
        $master->mobileno       = '09481663230';
        $master->role           = 'admin';
        $master->password       = bcrypt('0okm9ijn8uhb');
        $master->remember_token = null;
        $master->save();

    }
}