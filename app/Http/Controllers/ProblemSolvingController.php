<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProblemSolvingController extends Controller
{
    public function find_min_max(Request $request) {
        $numbers = $request->numbers;
        $min_sum = $numbers[0];
        $max_sum = $numbers[0];
        $sum = $numbers[0];

        for ($i = 1; $i < count($numbers); $i++) {
            $sum += $numbers[$i];
            if($min_sum > $numbers[$i]) $min_sum = $numbers[$i];
            if($max_sum < $numbers[$i]) $max_sum = $numbers[$i];
        }

        return $sum-$max_sum .'  ' .$sum - $min_sum;
    }

    public function ratio(Request $request){
        $numbers = $request->numbers;
        $positive_ratio = number_format($this->count_positive($numbers)/count($numbers),6,'.');
        $negative_ratio = number_format($this->count_negative($numbers)/count($numbers),6,'.');
        $zero_ratio = number_format($this->count_zero($numbers)/count($numbers),6,'.');
        return $positive_ratio."\r\n".$negative_ratio."\r\n".$zero_ratio;
    }

    public function count_negative($numbers){
        $i = 0;
        foreach($numbers as $number){
            if($number < 0) $i++;
        }
        return $i;
    }
    public function count_positive($numbers){
        $i = 0;
        foreach($numbers as $number){
            if($number > 0) $i++;
        }
        return $i;
    }
    public function count_zero($numbers){
        $i = 0;
        foreach($numbers as $number){
            if($number == 0) $i++;
        }
        return $i;
    }

    public function formatHour(Request $request){
        $hour = $request->hour;
        $time  = date("H:i:s", strtotime($hour));
        return $time;
    }
}

