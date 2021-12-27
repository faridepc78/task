<?php

namespace App\Repositories;

use App\Filters\User\Search;
use App\Helpers\PaginationHelper;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class UserRepository
{
    public function paginate()
    {
        $data = app(Pipeline::class)
            ->send(User::query())
            ->through([
                Search::class
            ])
            ->thenReturn()
            ->latest()
            ->get();

        return PaginationHelper::paginate($data->where('role', User::USER), 10);
    }

    public function store($values)
    {
        return User::query()
            ->create([
                'f_name' => $values['f_name'],
                'l_name' => $values['l_name'],
                'email' => $values['email'],
                'password' => bcrypt($values['password'])
            ]);
    }

    public function update($values, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'f_name' => $values['f_name'],
                'l_name' => $values['l_name'],
                'email' => $values['email']
            ]);
    }

    public function updatePassword($password, $id)
    {
        return User::query()
            ->where('id', '=', $id)
            ->update([
                'password' => bcrypt($password)
            ]);
    }

    public function random()
    {
        return User::query()
            ->inRandomOrder()
            ->select('id')
            ->first();
    }
}
