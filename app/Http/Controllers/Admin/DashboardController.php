<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\StatisticsRepository;

class DashboardController extends Controller
{
    protected $statisticsRepository;

    public function __construct(StatisticsRepository $statisticsRepository)
    {
        $this->statisticsRepository = $statisticsRepository;
    }

    public function __invoke()
    {
        $admins = $this->statisticsRepository->getCountAdmins();
        $users = $this->statisticsRepository->getCountUsers();
        $lotteries = $this->statisticsRepository->getCountLotteries();
        return view('admin.dashboard.index',
            compact('admins', 'users', 'lotteries'));
    }
}
