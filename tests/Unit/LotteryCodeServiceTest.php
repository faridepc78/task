<?php

use App\Models\Lottery;
use App\Models\User;
use App\Repositories\LotteryRepository;
use App\Services\Lottery\LotteryCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotteryCodeServiceTest extends TestCase
{
    use RefreshDatabase;

    private function runClass()
    {
        return new LotteryCodeService(new LotteryRepository());
    }

    private function createUser()
    {
        return User::query()
            ->create([
                'f_name' => 'farid',
                'l_name' => 'shishebori',
                'email' => 'farid@gmail.com',
                'password' => bcrypt('12345678')
            ]);
    }

    private function createLottery()
    {
        return Lottery::query()
            ->create([
                'code' => $this->runClass()->generate(),
                'user_id' => $this->createUser()->id
            ]);
    }

    public function test_generated_normal_code()
    {
        $code = $this->runClass()->generate();
        $this->assertIsNumeric($code);
    }

    public function test_generated_try_code()
    {
        $lottery = $this->createLottery();
        $new_code = $this->runClass()->checkValid($lottery->code);
        $this->assertNotEquals($lottery->code, $new_code);
        $this->assertIsNumeric($new_code);
    }
}
