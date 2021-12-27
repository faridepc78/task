<?php


namespace App\Filters\Lottery;


use App\Filters\Filter;

class Search extends Filter
{
    protected function applyFilter($builder)
    {
        $keyword = request($this->filterName());

        if ($keyword != null) {
            if (is_numeric($keyword)) {
                return $builder->where('code', $keyword);
            } elseif (is_string($keyword)) {
                return $builder->whereHas('user', function ($query) use ($keyword) {
                    $query->where('f_name', 'like', '%' . $keyword . '%')
                        ->orWhere('l_name', 'like', '%' . $keyword . '%')
                        ->orWhereRaw("concat(f_name, ' ', l_name) like '%$keyword%' ");;
                });
            }
        } else {
            return $keyword;
        }
    }
}
