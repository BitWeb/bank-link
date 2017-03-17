<?php
namespace BitWeb\BankLink\Swedbank;

use BitWeb\BankLink\BankLink;
use BitWeb\BankLink\Swedbank\Constants;

final class Swedbank extends BankLink
{
    /**
     * Bank URL
     * @var string
     */
    protected $url = 'https://www.swedbank.ee/banklink';

    /**
     * BankId
     * @var string
     */
    protected $bankId = Constants::BANK_ID;

    protected static function getParameterLength($fieldName) {
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }
}
