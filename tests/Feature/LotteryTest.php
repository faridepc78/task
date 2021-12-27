<?php

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use App\Models\Lottery;
use App\Models\User;
use App\Repositories\LotteryRepository;
use App\Repositories\UserRepository;
use App\Services\Lottery\LotteryCodeService;
use App\Services\Lottery\LotteryUserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class LotteryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;


    /*START CHECK INDEX*/

    public function test_admin_can_see_lotteries_index()
    {
        $this->actionAsAdmin();
        $this->get(route('lotteries.index'))->assertOk();
    }

    public function test_user_without_login_can_not_see_lotteries_index()
    {
        $this->get(route('lotteries.index'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_lotteries_index()
    {
        $this->actionAsUser();
        $this->get(route('lotteries.index'))->assertStatus(403);
    }

    /*END CHECK INDEX*/


    /*START CHECK CREATE*/

    public function test_admin_can_see_create_lotteries()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Database\QueryException');

        $this->actionAsAdmin();
        $this->get(route('lotteries.create'))->assertOk();
    }

    public function test_user_without_login_can_not_see_create_lotteries()
    {
        $this->get(route('lotteries.create'))->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_create_lotteries()
    {
        $this->actionAsUser();
        $this->get(route('lotteries.create'))->assertStatus(403);
    }

    /*END CHECK CREATE*/


    /*START CHECK STORE*/

    public function test_admin_can_see_store_lotteries()
    {
        $this->withoutExceptionHandling();

        // prevent validation error on captcha
        NoCaptcha::shouldReceive('verifyResponse')
            ->once()
            ->andReturn(true);

        // provide hidden input for your 'required' validation
        NoCaptcha::shouldReceive('display')
            ->zeroOrMoreTimes()
            ->andReturn('<input type="hidden" name="g-recaptcha-response" value="1" />');

        $this->actionAsAdmin();

        $this->createUserData();

        $response = $this->post(route('lotteries.store'), [
            'g-recaptcha-response' => make_token(100)
        ]);

        $lottery=  $this->createLottery();

        $token = Crypt::encryptString($lottery['code']);

        $response->assertStatus(302);

        $response = $this->get(route('lotteries.result', ['token' => $token]));
        $response->assertStatus(200);
        $this->assertEquals(1, Lottery::count());
    }

    public function test_user_without_login_can_not_see_store_lotteries()
    {
        $response = $this->post(route('lotteries.store'), [
            'g-recaptcha-response' => make_token(100)
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertEquals(0, Lottery::count());
    }

    public function test_user_with_login_can_not_see_store_lotteries()
    {
        $this->actionAsUser();
        $response = $this->post(route('lotteries.store'), [
            'g-recaptcha-response' => make_token(100)
        ]);

        $response->assertStatus(403);
        $this->assertEquals(0, Lottery::count());
    }

    /*END CHECK STORE*/


    /*START CHECK RESULT*/

    public function test_admin_can_see_result_lotteries()
    {
        $this->actionAsAdmin();

        $this->createUserData();

        $lottery = $this->createLottery();

        $token = Crypt::encryptString($lottery['code']);

        $response = $this->get(route('lotteries.result', ['token' => $token]))->assertOk();
        $response->assertStatus(200);
        $this->assertEquals(1, Lottery::count());
    }

    public function test_user_without_login_can_not_see_result_lotteries()
    {
        $this->createUserData();

        $lottery = $this->createLottery();

        $token = Crypt::encryptString($lottery['code']);

        $this->get(route('lotteries.result', ['token' => $token]))
            ->assertStatus(302)->assertRedirect(route('login'));
    }

    public function test_user_with_login_can_not_see_result_lotteries()
    {
        $this->actionAsUser();

        $lottery = $this->createLottery();

        $token = Crypt::encryptString($lottery['code']);


        $this->get(route('lotteries.result', ['token' => $token]))
            ->assertStatus(403);
    }

    /*END CHECK RESULT*/


    /*START CHECK DESTROY*/

    public function test_admin_can_delete_lotteries()
    {
        $this->actionAsAdmin();
        $this->createUserData();
        $lottery = $this->createLottery();
        $this->delete(route('lotteries.destroy', $lottery->id))
            ->assertStatus(302)
            ->assertRedirect(route('lotteries.index'));
        $this->assertEquals(0, Lottery::count());
    }

    public function test_user_without_login_can_not_delete_lotteries()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->createUserData();
        $lottery = $this->createLottery();
        $this->delete(route('lotteries.destroy', $lottery->id))
            ->assertStatus(302)->assertRedirect(route('login'));
        $this->assertEquals(1, Lottery::count());
    }

    public function test_user_with_login_can_not_delete_lotteries()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->actionAsUser();
        $lottery = $this->createLottery();
        $this->delete(route('lotteries.destroy', $lottery->id))
            ->assertStatus(403);
        $this->assertEquals(1, Lottery::count());
    }

    /*END CHECK DESTROY*/


    private function createUserData()
    {
        return User::query()
            ->create([
                'f_name' => $this->faker->unique->firstName,
                'l_name' => $this->faker->unique->lastName,
                'email' => $this->faker->unique->safeEmail,
                'password' => bcrypt('12345678')
            ]);
    }

    private function actionAsUser()
    {
        $this->actingAs($this->createUserData());
        auth()->check();
    }

    private function createAdminData()
    {
        return User::query()
            ->create([
                'f_name' => 'farid',
                'l_name' => 'shishebori',
                'email' => 'farid@gmail.com',
                'password' => bcrypt('12345678'),
                'role' => User::ADMIN
            ]);
    }

    private function actionAsAdmin()
    {
        $this->actingAs($this->createAdminData());
        auth()->check();
    }

    private function createLottery()
    {
        $data = $this->lotteryData();
        return Lottery::query()->create($data);
    }

    private function lotteryData()
    {
        $lcs = new LotteryCodeService(new LotteryRepository());
        $lus = new LotteryUserService(new LotteryRepository(), new UserRepository());
        return [
            'code' => $lcs->generate(),
            'user_id' => $lus->generate()
        ];
    }
}
