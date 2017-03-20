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

    protected static function getParameterLength($fieldName) {
        $fieldName = str_replace('VK_', '', $fieldName);
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }
}
