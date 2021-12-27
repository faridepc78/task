<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lottery\LotteryRequest;
use App\Models\Lottery;
use App\Repositories\LotteryRepository;
use App\Services\Lottery\LotteryCodeService;
use App\Services\Lottery\LotteryUserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LotteryController extends Controller
{
    protected $lotteryRepository;
    protected $lotteryCodeService;
    protected $lotteryUserService;

    public function __construct(LotteryRepository  $lotteryRepository,
                                LotteryCodeService $lotteryCodeService,
                                LotteryUserService $lotteryUserService)
    {
        $this->lotteryRepository = $lotteryRepository;
        $this->lotteryCodeService = $lotteryCodeService;
        $this->lotteryUserService = $lotteryUserService;
    }

    public function index()
    {
        $lotteries = $this->lotteryRepository->paginate();
        return view('admin.lotteries.index', compact('lotteries'));
    }

    public function create()
    {
        return view('admin.lotteries.create');
    }

    public function store(LotteryRequest $request)
    {
        try {
            $code = $this->lotteryCodeService->generate();
            $user_id = $this->lotteryUserService->generate();
            $lottery = $this->lotteryRepository->store($code, $user_id);
            $token = Crypt::encryptString($lottery['code']);
            newFeedback();
            return redirect()->route('lotteries.result', ['token' => $token]);
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->route('lotteries.create');
        }
    }

    public function result(Request $request)
    {
        try {
            if ($request->exists('token')) {
                $code = Crypt::decryptString($request->input('token'));
                $lottery = $this->lotteryRepository->findByCode($code);
                return view('admin.lotteries.result', compact('lottery'));
            } else {
                abort(404);
            }
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
            return redirect()->route('lotteries.create');
        }
    }

    public function destroy(Lottery $lottery)
    {
        try {
            $lottery->delete();
            newFeedback();
        } catch (Exception $exception) {
            newFeedback('پیام', 'عملیات با شکست مواجه شد', 'error');
        }
        return redirect()->route('lotteries.index');
    }
}
