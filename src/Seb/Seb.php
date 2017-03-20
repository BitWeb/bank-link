<?php
namespace BitWeb\BankLink\Seb;

use BitWeb\BankLink\BankLink;
use BitWeb\BankLink\Seb\Constants;

final class Seb extends BankLink
{
    /**
     * Bank URL for form submitting
     * @var string
     */
    protected $url = 'https://www.seb.ee/cgi-bin/unet3.sh/un3min.r';

    /**
     * Bank id
     * @var string
     */
    protected $bankId = Constants::BANK_ID;

    protected static function getParameterLength($fieldName) {
        $fieldName = str_replace('VK_', '', $fieldName);
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }
}
