<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\LotteryRepository;

class MainController extends Controller
{
    protected $lotteryRepository;

    public function __construct(LotteryRepository $lotteryRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
    }

    public function __invoke()
    {
        $lotteries = $this->lotteryRepository->paginate();
        return view('site.home.index', compact('lotteries'));
    }
}
