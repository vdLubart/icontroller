<?php
/**
 * Created by PhpStorm.
 * User: lubart
 * Date: 07.12.21
 * Time: 17:26
 */

namespace App\Services;

use Carbon\Carbon;

class Payment {

    /**
     * Return the salary payment date for the given month and year
     *
     * @param int $month
     * @param int $year
     *
     * @return Carbon
     */
    public function salaryDate(int $month, int $year): Carbon {
        $month = $this->checkMonth($month);
        $lastMonthDay = Carbon::create($year, $month, 1)->lastOfMonth();

        switch ($lastMonthDay->dayName){
            case 'Sunday':
                $lastMonthDay->addDays(-2);
                break;
            case 'Saturday':
                $lastMonthDay->addDays(-1);
                break;
        }

        return $lastMonthDay;
    }

    /**
     * Return the bonus payment date for the given month and year
     *
     * @param int $month
     * @param int $year
     *
     * @return Carbon|false
     */
    public function bonusDate(int $month, int $year): Carbon {
        $month = $this->checkMonth($month);
        $fifteenth = Carbon::create($year, $month, 15)->addMonth();

        switch ($fifteenth->dayName){
            case 'Sunday':
                $fifteenth->addDays(3);
                break;
            case 'Saturday':
                $fifteenth->addDays(4);
                break;
        }

        return $fifteenth;
    }

    /**
     * @param int $month
     * @return int
     */
    private function checkMonth(int $month): int {
        if($month < 1 or $month > 12){
            $month = 1;
        }

        return $month;
    }

}
