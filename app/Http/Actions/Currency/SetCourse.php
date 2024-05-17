<?php

namespace App\Http\Actions\Currency;

class SetCourse
{
    public function run($currency, $course)
    {
        $currency->update([
            'course' => $course,
        ]);
    }
}
