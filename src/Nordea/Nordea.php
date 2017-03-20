<?php
namespace BitWeb\BankLink\Nordea;

use BitWeb\BankLink\BankLink;
use BitWeb\BankLink\Nordea\Constants;

final class Nordea extends BankLink
{

    /**
     * Bank URL for form submitting
     *
     * @var string
     */
    protected $url = 'https://netbank.nordea.com/pnbepay/epayp.jsp';

    /**
     * Bank id
     *
     * @var string
     */
    protected $bankId = Constants::BANK_ID;

    protected static function getParameterLength($paramKey) {
        $paramKey = str_replace('VK_', '', $paramKey);
        if($paramKey == 'RETURN') $paramKey = 'RETURN_URL';
        return constant(Constants::class.'::'.$paramKey.'_LENGTH');
    }
}
