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

    protected static function getParameterLength($fieldName) {
        $fieldName = str_replace('VK_', '', $fieldName);
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }
}
