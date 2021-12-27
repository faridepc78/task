<?php

use App\Models\Lottery;
use App\Models\User;
use App\Repositories\LotteryRepository;
use App\Repositories\UserRepository;
use App\Services\Lottery\LotteryCodeService;
use App\Services\Lottery\LotteryUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotteryUserServiceTest extends TestCase
{
    use RefreshDatabase;

    private function runClass()
    {
        return new LotteryUserService(new LotteryRepository(), new UserRepository());
    }

    private function generateCode()
    {
        $lotteryCodeService = new LotteryCodeService(new LotteryRepository);
        return $lotteryCodeService->generate();
    }

    private function createUser1()
    {
        return User::query()
            ->create([
                'f_name' => 'farid',
                'l_name' => 'shishebori',
                'email' => 'farid@gmail.com',
                'password' => bcrypt('12345678')
            ]);
    }

    private function createUser2()
    {
        return User::query()
            ->create([
                'f_name' => 'ali',
                'l_name' => 'ghasemi',
                'email' => 'ali@gmail.com',
                'password' => bcrypt('12345678')
            ]);
    }

    private function createLottery()
    {
        return Lottery::query()
            ->create([
                'code' => $this->generateCode(),
                'user_id' => $this->createUser1()->id
            ]);
    }

    public function test_generated_normal_user()
    {
        $this->createUser1();
        $this->createUser2();
        $user = $this->runClass()->generate();
        $this->assertIsNumeric($user);
        $this->assertEquals(2, User::count());
    }

    public function test_generated_try_user()
    {
        $this->createLottery();
        $this->createUser2();
        $new_user = $this->runClass()->checkValid(1);
        $this->assertNotEquals(1, $new_user);
        $this->assertIsNumeric($new_user);
    }
}
