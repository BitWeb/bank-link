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

    protected static function getParameterLength($paramKey) {
        $paramKey = str_replace('VK_', '', $paramKey);
        if($paramKey == 'RETURN') $paramKey = 'RETURN_URL';
        if($paramKey == 'CANCEL') $paramKey = 'CANCEL_URL';
        return constant(Constants::class.'::'.$paramKey.'_LENGTH');
    }
}
