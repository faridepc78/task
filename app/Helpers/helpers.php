<?php

use Illuminate\Support\Arr;

function newFeedback($title = 'پیام', $body = 'عملیات با موفقیت انجام شد', $type = 'success')
{
    $session = session()->has('feedbacks') ? session()->get('feedbacks') : [];
    $session[] = ['title' => $title, 'body' => $body, 'type' => $type];
    session()->flash('feedbacks', $session);
}

function randomNumbers($count)
{
    $numbers = '0123456789';

    $randomNumbers = '';

    for ($i = 0; $i < $count; $i++) {
        $index = rand(0, strlen($numbers) - 1);
        $randomNumbers .= $numbers[$index];
    }

    return $randomNumbers;
}

function convert($string)
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

    $num = range(0, 9);
    $convertedPersianNums = str_replace($persian, $num, $string);
    $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

    return $englishNumbersOnly;
}

function cleanExtraQueryString(array $remove_data = null, array $add_data = null, $route)
{
    $oldQuery = request()->query();

    if ($remove_data != null) {
        $newQuery = Arr::except($oldQuery, $remove_data);
    } else {
        $newQuery = $oldQuery;
    }

    if ($add_data != null) {
        $finalQuery = array_merge($newQuery, $add_data);
    } else {
        $finalQuery = $newQuery;
    }

    $url = route($route, $finalQuery);
    return $url;
}

function getGravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

?>
