<?php

namespace BitWeb\BankLink\Nordea;

use BitWeb\BankLink\BankLink;

/**
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 *            Change Log:
 *            Date            User        Comment
 *            ---------------------------------
 *            Mar 29, 2009    tobre    Initial version
 */
final class Nordea extends BankLink
{

    /**
     * Bank URL for form submitting
     *
     * @var string
     */
    protected $url = 'https://netbank.nordea.com/pnbepay/epayn.jsp';

    /**
     * Bank id
     *
     * @var string
     */
    protected $bankId = Constants::BANK_ID;

    /**
     * MAC version.
     *
     * @var string
     */
    protected $version = '0003';

    /**
     * Currency
     *
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * Default communication language
     *
     * @var string
     */
    protected $language = '4';

    private $date = 'EXPRESS';

    protected function addCommonParameters($service, $isFailedDealing = false)
    {
        $this->setServiceMetadata($isFailedDealing);
        $this->addMacParameter(Constants::VERSION, Constants::VERSION_LENGTH, $this->version);
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
    }

    protected function setSpecificParameters()
    {
    }

    public function create1002()
    {
        $this->addCommonParameters(1002);

        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, $this->stamp);
        $this->addMacParameter(Constants::RCV_ID, Constants::RCV_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH, $this->amount);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH, $this->referenceNumber(1));
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH, $this->date);
        $this->addMacParameter(Constants::CUR, Constants::CUR_LENGTH, $this->currency);

        $this->addParameter(Constants::RCV_ACCOUNT, Constants::RCV_ACCOUNT_LENGTH, $this->accountNumber);
        $this->addParameter(Constants::RCV_NAME, Constants::RCV_NAME_LENGTH, $this->clientName);
        $this->addParameter(Constants::LANGUAGE, Constants::LANGUAGE_LENGTH, $this->language);
        $this->addParameter(Constants::MSG, Constants::MSG_LENGTH, $this->message);
        $this->addParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addParameter(Constants::CANCEL_URL, Constants::CANCEL_URL_LENGTH, $this->returnUrl);
        $this->addParameter(Constants::REJECT_URL, Constants::REJECT_URL_LENGTH, $this->returnUrl);
        $this->addParameter(Constants::CONFIRM, Constants::CONFIRM_LENGTH, 'YES');
        $this->addParameter(Constants::KEYVERS, Constants::KEYVERS_LENGTH, '0001');
    }

    protected function calculateMac()
    {
        $fields = array();
        foreach ($this->getMacParameters() as $order) {
            $fields[] = $this->parameters[$order]->getFormattedValue();
        }

        $signature = strtoupper(md5(implode('&', $fields) . '&' . $this->getPrivateKey() . '&'));
        $this->parameters[Constants::MAC]->setValue($signature);

        return $signature;
    }


    protected function verifyMac()
    {
// 		throw new Exception('Verifying failed');
    }

    public function getResponse()
    {
        $this->loadValues();

        return false;
    }

    public function isResponse()
    {

        return isset($_GET['SOLOPMT_RETURN_']);
    }

    protected function referenceNumber($ixOrder)
    {
        // reference number calculation using the algorithm provided by Pankade liit
        $rsMultiplier = array(
            7,
            3,
            1
        );
        $ixCurrentMultiplier = 0;
        $sixOrder = (string)$ixOrder;
        for ($i = strlen($sixOrder) - 1; $i >= 0; $i--) {
            $rsProduct[$i] = substr($sixOrder, $i, 1) * $rsMultiplier[$ixCurrentMultiplier];
            if ($ixCurrentMultiplier == 2) {
                $ixCurrentMultiplier = 0;
            } else {
                $ixCurrentMultiplier++;
            }
        }
        $sumProduct = 0;
        foreach ($rsProduct as $product) {
            $sumProduct += $product;
        }
        if ($sumProduct % 10 == 0) {
            $ixReference = 0;
        } else {
            $ixReference = 10 - ($sumProduct % 10);
        }
        return $sixOrder . $ixReference;
    }
}
