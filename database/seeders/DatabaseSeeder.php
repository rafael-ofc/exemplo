<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Area;
use App\Models\AreaDisabled;
use App\Models\Billet;
use App\Models\Doc;
use App\Models\Like;
use App\Models\Lost;
use App\Models\People;
use App\Models\Pet;
use App\Models\Reservation;
use App\Models\Unit;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Wall;
use App\Models\Warning;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Unit::factory(5)->create();
        People::factory(10)->create();
        Vehicle::factory(5)->create();
        Pet::factory(5)->create();
        Wall::factory(10)->create();
        Like::factory(5)->create();
        Doc::factory(5)->create();
        Billet::factory(5)->create();
        Warning::factory(10)->create();
        Lost::factory(10)->create();
        Area::factory(10)->create();
        AreaDisabled::factory(5)->create();
        Reservation::factory(5)->create();
    }
}
