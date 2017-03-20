<?php
namespace BitWeb\BankLink\Danske;

use BitWeb\BankLink\BankLink;

final class Danske extends BankLink
{

    /**
     * Bank URL for form submitting
     * @var string
     */
    protected $url = 'https://www2.danskebank.ee/ibank/pizza/pizza';

    protected $bankId = Constants::BANK_ID;

    protected static function getParameterLength($paramKey) {
        $paramKey = str_replace('VK_', '', $paramKey);
        if($paramKey == 'RETURN') $paramKey = 'RETURN_URL';
        if($paramKey == 'CANCEL') $paramKey = 'CANCEL_URL';
        return constant(Constants::class.'::'.$paramKey.'_LENGTH');
    }
}
