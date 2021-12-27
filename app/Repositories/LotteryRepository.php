<?php

namespace App\Repositories;

use App\Filters\Lottery\Date;
use App\Filters\Lottery\Search;
use App\Models\Lottery;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class LotteryRepository
{
    public function paginate()
    {
        return app(Pipeline::class)
            ->send(Lottery::query())
            ->through([
                Search::class,
                Date::class
            ])
            ->thenReturn()
            ->latest()
            ->paginate(10);
    }

    public function store($code, $user_id)
    {
        return Lottery::query()
            ->create([
                'code' => $code,
                'user_id' => $user_id
            ]);
    }

    public function checkColumn($column, $value)
    {
        if ($column == 'user') {
            return Lottery::query()
                ->whereHas('user', function ($query) use ($value) {
                    $query->where('id', $value);
                })
                ->exists();
        } elseif ($column == 'code') {
            return Lottery::query()
                ->where($column, $value)
                ->exists();
        } else {
            return false;
        }
    }

    public function findByCode($code)
    {
        return Lottery::query()
            ->whereCode($code)
            ->firstOrFail();
    }
}
