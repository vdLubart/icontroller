<?php

namespace App\Http\Controllers;

use App\Facades\Payment;
use App\Http\Requests\GenerateCalendarRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param GenerateCalendarRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateCalendar(GenerateCalendarRequest $request): JsonResponse {
        $year = $request->year;
        $calendar = [];
        foreach (range(1, 12) as $month){
            $salaryDate = Payment::salaryDate($month, $year);
            $bonusDate = Payment::bonusDate($month, $year);
            $calendar[] = [
                'month' => $salaryDate->monthName . ' ' . $salaryDate->year,
                'salaryDate' => $salaryDate->format('D, F dS'),
                'bonusDate' => $bonusDate->format('D, F dS')
            ];
        }

        return response()->json($calendar);
    }
}
