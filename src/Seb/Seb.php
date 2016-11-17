<?php

namespace BitWeb\BankLink\Seb;

use BitWeb\BankLink\BankLink;

/**
 * SEB bank specific BankLink creating class
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 24, 2009    tobre    Initial version
 */
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

    /**
     * Charset for connection. Default value is UTF-8
     * @var string
     */
    private $charset = 'UTF-8';

    /**
     * Setting charset for connection
     * @param string $charset Charset type. Supperted is UTF-8 and ISO-8859-1. Default is UTF-8
     * @return Seb object
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
        return $this;
    }


    /*
     * (non-PHPdoc)
     * @see BankLink/BankLink#setSpecificParameters()
     */
    protected function setSpecificParameters()
    {
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
        $this->addParameter(Constants::CHARSET, Constants::CHARSET_LENGTH, $this->charset);
    }

    /**
     * Teenus 1001
     * Teenindaja saadab Panka Kliendi sooviavalduse Tehingu tegemiseks.
     */
    protected function create1001()
    {
        $this->addCommonParameters(1001);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, $this->stamp);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH, $this->amount);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH, $this->currency);
        $this->addMacParameter(Constants::ACC, Constants::ACC_LENGTH, $this->accountNumber);
        $this->addMacParameter(Constants::NAME, Constants::NAME_LENGTH, $this->clientName);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH, $this->referenceNumber);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH, $this->message);
        $this->addParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
        $this->addParameter(Constants::CANCEL_URL, Constants::CANCEL_URL_LENGTH, $this->returnUrl);
    }

    /**
     * Teenus 1002
     * Teenindaja saadab Panka Kliendi sooviavalduse Tehingu tegemiseks.
     * Makse saaja nimi ja konto number võetakse Panga ja Teenindaja vahelisest lepingust.
     */
    protected function create1002()
    {
        $this->addCommonParameters(1002);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, $this->stamp);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH, $this->amount);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH, $this->currency);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH, $this->referenceNumber);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH, $this->message);
        $this->addParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addParameter(Constants::CANCEL_URL, Constants::CANCEL_URL_LENGTH, $this->returnUrl);
    }

    /**
     * Teenus 1101
     * Vastus Tehingu aktsepteerimise kohta
     */
    protected function create1101()
    {
        $this->addCommonParameters(1101);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, 1);
        $this->addMacParameter(Constants::T_NO, Constants::T_NO_LENGTH);
        $this->addMacParameter(Constants::AMOUNT, Constants::AMOUNT_LENGTH);
        $this->addMacParameter(Constants::CURR, Constants::CURR_LENGTH, $this->currency);
        $this->addMacParameter(Constants::REC_ACC, Constants::REC_ACC_LENGTH);
        $this->addMacParameter(Constants::REC_NAME, Constants::REC_NAME_LENGTH);
        $this->addMacParameter(Constants::SND_ACC, Constants::SND_ACC_LENGTH);
        $this->addMacParameter(Constants::SND_NAME, Constants::SND_NAME_LENGTH);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addMacParameter(Constants::T_DATE, Constants::T_DATE_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }

    /**
     * Teenus 1901
     * Vastus Tehingu aktsepteerimata jätmise kohta
     */
    protected function create1901()
    {
        $this->addCommonParameters(1901, true);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, 1);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }

    /**
     * Teenus 1902
     * Kasutatakse ebaõnnestunud tehingutest teatamiseks. Lisaks on väli VK_ERROR_CODE, mis näitab kokkulepitud veakoodi
     */
    protected function create1902()
    {
        $this->addCommonParameters(1902, true);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, 1);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addMacParameter(Constants::ERROR_CODE, Constants::ERROR_CODE_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }

    /**
     * Teenus 3001
     * Teenindajale edastatakse kasutaja indifikaator ning paketi genereerimise kuupäev ja kellaaeg.
     */
    protected function create3001()
    {
        $this->addCommonParameters(3001);
        $this->addMacParameter(Constants::USER, Constants::USER_LENGTH);
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH);
        $this->addMacParameter(Constants::TIME, Constants::TIME_LENGTH);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
    }

    /**
     * Teenus 3002
     * Teenindajale edastatakse kasutaja indifikaator ning paketi genereerimise kuupäev ja kellaaeg.
     * Väli VK_INFO sisaldab infot Teenindajaga kokkulepitaval kujul.
     * Üks võimalusi on, et väli sisaldab semikoolonitega eraldatud paare kujul "NIMI:VÄÄRTUS"
     */
    protected function create3002()
    {
        $this->addCommonParameters(3002);
        $this->addMacParameter(Constants::USER, Constants::USER_LENGTH);
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH);
        $this->addMacParameter(Constants::TIME, Constants::TIME_LENGTH);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::INFO, Constants::INFO_LENGTH);
    }

    /**
     * Teenus 3003
     * Kaupmehele edastatakse kasutaja isikukood ja nimi
     */
    protected function create3003()
    {
        $this->addCommonParameters(3003);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::NONCE, Constants::NONCE_LENGTH, $this->generateNonce());
        $this->addMacParameter(Constants::INFO, Constants::INFO_LENGTH);
    }

    /**
     * Teenus 4001
     * Kaupmehe poolt saadetav päring U-Neti kasutaja identifitseerimiseks
     */
    protected function create4001()
    {
        $this->addCommonParameters(4001);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REPLY, Constants::REPLY_LENGTH, 3002);
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH);
        $this->addMacParameter(Constants::TIME, Constants::TIME_LENGTH);
    }

    /**
     * Teenus 4002
     * Kaupmehe poolt saadetav päring U-Neti kasutaja identifitseerimiseks
     */
    protected function create4002()
    {
        $this->addCommonParameters(4002);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::NONCE, Constants::NONCE_LENGTH, $this->generateNonce());
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
    }

    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3012.
     */
    protected function create4011() {
        $this->addCommonParameters(4011);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REPLY, Constants::REPLY_LENGTH, 3012);
        $this->addMacParameter(Constants::RETURN_URL, 255, $this->returnUrl);
        $this->addMacParameter(Constants::DATETIME, Constants::DATETIME_LENGTH);
        $this->addMacParameter(Constants::RID, Constants::RID_LENGTH);
    }

    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3013.
     */
    protected function create4012() {
        $this->addCommonParameters(4012);
        $this->addMacParameter(Constants::SND_ID, 15, $this->storeId);
        $this->addMacParameter(Constants::REC_ID, 15);
        $this->addMacParameter(Constants::NONCE, 50);
        $this->addMacParameter(Constants::RETURN_URL, 255, $this->returnUrl);
        $this->addMacParameter(Constants::DATETIME, 24);
        $this->addMacParameter(Constants::RID, 30);
    }

}
