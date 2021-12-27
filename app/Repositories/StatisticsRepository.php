<?php

namespace App\Repositories;

use App\Models\Lottery;
use App\Models\User;

class StatisticsRepository
{
    public function getCountAdmins()
    {
        return User::query()
            ->whereRole(User::ADMIN)
            ->count();
    }

    public function getCountUsers()
    {
        return User::query()
            ->whereRole(User::USER)
            ->count();
    }

    public function getCountLotteries()
    {
        return Lottery::query()
            ->count();
    }
}
