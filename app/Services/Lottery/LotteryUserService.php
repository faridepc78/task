<?php

namespace App\Services\Lottery;

use App\Repositories\LotteryRepository;
use App\Repositories\UserRepository;

class LotteryUserService
{
    protected $lotteryRepository;
    protected $userRepository;

    public function __construct(LotteryRepository $lotteryRepository,
                                UserRepository    $userRepository)
    {
        $this->lotteryRepository = $lotteryRepository;
        $this->userRepository = $userRepository;
    }

    public function generate()
    {
        $user = $this->userRepository->random();

        return $this->checkValid($user->id);
    }

    public function checkValid(int $user_id)
    {
        $result = $this->lotteryRepository->checkColumn('user', $user_id);

        return $result == true ? $this->generate() : $user_id;
    }
}
