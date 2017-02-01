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

    protected function setSpecificParameters()
    {
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
        $this->addParameter(Constants::ENCODING, Constants::ENCODING_LENGTH, $this->encoding);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
    }

    /**
     * Teenus 1011
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient internetipangas muuta ei saa.
     * Pärast edukat makset koostatakse kaupmehele päring “1111”, ebaõnnestunud makse puhul “1911”
     */
    protected function create1011()
    {
        $this->addCommonParameters('1011');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, $this->stamp);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH, $this->amount);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH, $this->currency);
        $this->addMacParameter(Constants::ACC, Constants::ACC_LENGTH, $this->accountNumber);
        $this->addMacParameter(Constants::NAME, Constants::NAME_LENGTH, $this->clientName);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH, $this->referenceNumber);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH, $this->message);
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addMacParameter(Constants::CANCEL_URL, Constants::CANCEL_URL_LENGTH, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, '');
        }
    }

    /**
     * Teenus 1012
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient internetipangas muuta ei saa.
     * Pärast edukat makset koostatakse kaupmehele päring “1111”, ebaõnnestunud makse puhul “1911”
     */
    protected function create1012()
    {
        $this->addCommonParameters('1012');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, $this->stamp);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH, $this->amount);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH, $this->currency);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH, $this->referenceNumber);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH, $this->message);
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addMacParameter(Constants::CANCEL_URL, Constants::CANCEL_URL_LENGTH, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, '');
        }
    }

    /**
     * Teenus 1111
     * Vastus Tehingu aktsepteerimise kohta
     */
    protected function create1111()
    {
        $this->addCommonParameters('1111');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH);
        $this->addMacParameter(Constants::T_NO, Constants::T_NO_LENGTH);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH);
        $this->addMacParameter(Constants::REC_ACC, Constants::REC_ACC_LENGTH);
        $this->addMacParameter(Constants::REC_NAME, Constants::REC_NAME_LENGTH);
        $this->addMacParameter(Constants::SND_ACC, Constants::SND_ACC_LENGTH);
        $this->addMacParameter(Constants::SND_NAME, Constants::SND_NAME_LENGTH);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addMacParameter(Constants::T_DATETIME, Constants::T_DATETIME_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }

    /**
     * Teenus 1911
     * Kasutatakse ebaõnnestunud tehingust teatamiseks.
     */
    protected function create1911()
    {
        $this->addCommonParameters('1911');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }


    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3012.
     */
    protected function create4011() {
        $this->addCommonParameters('4011');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REPLY, Constants::REPLY_LENGTH, '3012');
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, '');
        }
        $this->addMacParameter(Constants::RID, Constants::RID_LENGTH, '');
    }

    /*
     * Kaupmehele edastatakse info kasutaja kohta ning paketi genereerimise kuupäev ja kellaaeg. Turvalisuse huvides peab
     * kaupmees kontrollima paketis olevat saatmise aega (VK_DATETIME). Väli VK_USER_NAME sisaldab kasutaja nime kujul
     * „perekonnanimi,eesnimi“ (näiteks: SAAR,JAAN).
     */
    protected function create3012() {
        $this->addCommonParameters('3012');
        $this->addMacParameter(Constants::USER, Constants::USER_LENGTH);
        $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::USER_NAME, Constants::USER_NAME_LENGTH);
        $this->addMacParameter(Constants::USER_ID, Constants::USER_ID_LENGTH);
        $this->addMacParameter(Constants::COUNTRY, Constants::COUNTRY_LENGTH);
        $this->addMacParameter(Constants::OTHER, Constants::OTHER_LENGTH);
        $this->addMacParameter(Constants::TOKEN, Constants::TOKEN_LENGTH);
        $this->addMacParameter(Constants::RID, Constants::RID_LENGTH);
    }

    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3013.
     */
    protected function create4012() {
        $this->addCommonParameters('4012');
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::NONCE, Constants::NONCE_LENGTH, self::generateNonce());
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH, '');
        }
        $this->addMacParameter(Constants::RID, Constants::RID_LENGTH, '');
    }

    /*
     * Kaupmehele edastatakse nonssi koopia.
     */
    protected function create3013() {
        $this->addCommonParameters('3013');
        $this->addMacParameter(Constants::USER, Constants::USER_LENGTH);
        $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::NONCE, Constants::NONCE_LENGTH);
        $this->addMacParameter(Constants::USER_NAME, Constants::USER_NAME_LENGTH);
        $this->addMacParameter(Constants::USER_ID, Constants::USER_ID_LENGTH);
        $this->addMacParameter(Constants::COUNTRY, Constants::COUNTRY_LENGTH);
        $this->addMacParameter(Constants::OTHER, Constants::OTHER_LENGTH);
        $this->addMacParameter(Constants::TOKEN, Constants::TOKEN_LENGTH);
        $this->addMacParameter(Constants::RID, Constants::REC_ID_LENGTH);
    }
}
