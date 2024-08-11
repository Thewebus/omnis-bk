<?php

namespace App\Services;

use Carbon\Carbon;

class TimeService {

    public function generateTimeRange($from, $to) {
        $time = Carbon::parse($from);
        $timeRange = [];

        do {
            array_push($timeRange, [
                'debut' => $time->format('H:i'),
                'fin' => $time->addMinutes(30)->format('H:i'),
            ]);
        }
        while($time->format('H:i') !== $to);

        return $timeRange;
    }
}
