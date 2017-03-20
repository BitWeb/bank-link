<?php

namespace BitWeb\BankLink\Krediidipank;

use BitWeb\BankLink\BankLink;
use BitWeb\BankLink\Krediidipank\Constants;

final class Krediidipank extends BankLink
{
    /**
     * Bank URL
     * @var string
     */
    protected $url = 'https://i-pank.krediidipank.ee/teller/autendi';

    /**
     * Bank ID
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
