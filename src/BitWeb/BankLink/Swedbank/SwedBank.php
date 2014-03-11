<?php
namespace BitWeb\BankLink\Swedbank;

use BitWeb\BankLink\BankLink;

/**
 * SwedBank specific bank link creating class
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 24, 2009    tobre    Initial version
 */
final class SwedBank extends BankLink
{

    /**
     * Bank URL
     * @var string
     */
    protected $url = 'https://www.swedbank.ee/banklink ';

    /**
     * BankId
     * @var string
     */
    protected $bankId = Constants::BANK_ID;
    
    /**
     * @var string
     */
    private $encoding = 'UTF-8';

    /* (non-PHPdoc)
     * @see BankLink/BankLink#setSpecificParameters()
     */
    protected function setSpecificParameters()
    {
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
        $this->addParameter(Constants::ENCODING, Constants::ENCODING_LENGTH, $this->encoding);
    }

    /**
     * Päring "1001"
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed,
     * mida klient internetipangas muuta ei saa. Peale edukat makset koostatakse kaupmehele
     * päring “1101”, ebaõnnestunud makse puhul “1901”
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
    }

    /**
     * Päring "1002"
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed,
     * mida klient internetipangas muuta ei saa. Peale edukat makset koostatakse kaupmehele
     * päring "1101", ebaõnnestunud makse puhul pakett "1901". Makse saaja andmed võetakse
     * pangalingi lepingust.
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
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
    }

    /**
     * Päring "1101"
     * Kasutatakse vastamiseks eestisisese maksekorralduse toimumisest.
     */
    protected function create1101()
    {
        $this->addCommonParameters(1101);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH);
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
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->langauge);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
        $this->addParameter(Constants::ENCODING, Constants::ENCODING_LENGTH, $this->encoding);
    }

    /**
     * Päring "1901"
     * Kasutatakse ebaõnnestunud tehingust teatamiseks.
     */
    protected function create1901()
    {
        $this->addCommonParameters(1901, true);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
    }

    /**
     * Päring "3002"
     * Kaupmehele edastatakse kasutaja identifikaator ning paketi genereerimise kuupäev ja kellaaeg.
     * Väli VK_INFO sisaldab semikoolonitega eraldatud nimi-väärtus paare kujul "NIMI:väärtus".
     * Näiteks "ISIK:37508166516;NIMI:JAAN SAAR".
     */
    protected function create3002()
    {
        $this->addCommonParameters(3002);
        $this->addMacParameter(Constants::USER, Constants::USER_LENGTH);
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH);
        $this->addMacParameter(Constants::TIME, Constants::TIME_LENGTH);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH);
        $this->addMacParameter(Constants::INFO, Constants::INFO_LENGTH);
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
    }

    /**
     * Päring "4001"
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     */
    protected function create4001()
    {
        $this->addCommonParameters(4001);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REPLY, Constants::REPLY_LENGTH);
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
        $this->addMacParameter(Constants::DATE, Constants::DATE_LENGTH);
        $this->addMacParameter(Constants::TIME, Constants::TIME_LENGTH);
    }

}
