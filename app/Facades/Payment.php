<?php
/**
 * Created by PhpStorm.
 * User: lubart
 * Date: 07.12.21
 * Time: 17:39
 */

namespace App\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\Facade;

/**
 * Class Payment
 * @package App\Facades
 *
 * @method static Carbon salaryDate(int $month, int $year)
 * @method static Carbon bonusDate(int $month, int $year)
 */
class Payment extends Facade {


    /**
     * @see \App\Services\Payment
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'payment';
    }

}
