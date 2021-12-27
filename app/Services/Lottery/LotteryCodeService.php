<?php

namespace App\Services\Lottery;

use App\Repositories\LotteryRepository;

class LotteryCodeService
{
    protected $lotteryRepository;

    public function __construct(LotteryRepository $lotteryRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
    }

    public function generate()
    {
        $code = randomNumbers(10);

        return $this->checkValid($code);
    }

    public function checkValid(int $code)
    {
        $result = $this->lotteryRepository->checkColumn('code', $code);

        return $result == true ? $this->generate() : $code;
    }
}
