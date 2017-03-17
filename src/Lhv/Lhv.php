<?php

namespace BitWeb\BankLink\Lhv;

use BitWeb\BankLink\BankLink;
use BitWeb\BankLink\Lhv\Constants;

final class Lhv extends BankLink
{
    /**
     * Bank URL for form submitting
     * @var string
     */
    protected $url = 'https://www.lhv.ee/banklink';

    /**
     * Bank id
     * @var string
     */
    protected $bankId = Constants::BANK_ID;

    protected static function getParameterLength($fieldName) {
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }
}
