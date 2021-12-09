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
     * Return calendar data in json format
     *
     * @param GenerateCalendarRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCalendar(GenerateCalendarRequest $request): JsonResponse {
        return response()->json($this->generateCalendar($request->year));
    }

    /**
     * Export calendar data to the csv file
     *
     * @param int $year
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportCalendar(int $year) {
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $data = $this->generateCalendar($year);
        $columns = array('Month', 'Salary Date', 'Bonus Date');

        $callback = function() use ($data, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($data as $line) {
                fputcsv($file, array($line['month'], $line['salaryDate'], $line['bonusDate']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate calendar data
     *
     * @param int $year
     * @return array
     */
    private function generateCalendar(int $year): array {
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

        return $calendar;
    }
}
