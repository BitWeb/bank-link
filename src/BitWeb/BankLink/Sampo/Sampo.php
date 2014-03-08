<?php
namespace BitWeb\BankLink\Sampo;

use BitWeb\BankLink\BankLink;

/**
 * Sampo Pank specific BankLink creating class
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 24, 2009    tobre    Initial version
 */
final class Sampo extends BankLink
{

    /**
     * Bank URL for form submitting
     * @var string
     */
    protected $url = 'https://www2.danskebank.ee/ibank/pizza/pizza';

    protected $bankId = Constants::BANK_ID;

    /*
     * (non-PHPdoc)
     * @see BankLink/BankLink#setSpecificParameters()
     */
    protected function setSpecificParameters()
    {
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
        $this->addParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
    }

    /**
     * NB! Väljal VK_RETURN ei ole lubatud kasutada parameetritega URL-i.
     * Päring "1001"
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient Sampo
     * Internetipangas muuta ei saa.
     * Peale edukat makset koostatakse kaupmehele päring “1101”, ebaõnnestunud makse puhul “1901”
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
    }

    /**
     * Päring "1002"
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient Sampo
     * Internetipangas muuta ei saa. Peale edukat makset koostatakse kaupmehele päring "1101",
     * ebaõnnestunud makse puhul pakett "1901". VK_SND_ID järgi pank ise leiab saaja konto numbri ja
     * saaja nime.
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
        $this->addParameter(Constants::AUTO, Constants::AUTO_LENGTH);
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
        $this->addMacParameter(Constants::STAMP, Constants::STAMP_LENGTH, 1);
        $this->addMacParameter(Constants::REF, Constants::REF_LENGTH);
        $this->addMacParameter(Constants::MSG, Constants::MSG_LENGTH);
    }

    /**
     * Päring "3001"
     * Kaupmehele edastatakse kasutaja identifikaator ning paketi genereerimise kuupäev ja
     * kellaaeg.
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
     * Päring "3002"
     * Kaupmehele edastatakse kasutaja identifikaator ning paketi genereerimise kuupäev ja
     * kellaaeg. Väli VK_INFO sisaldab semikoolonitega eraldatud nimi-väärtus paare kujul
     * "NIMI:väärtus". Näiteks "ISIK:37508166516;NIMI:JAAN SAAR".
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
     * Päring "3003"
     * Vastus päringule 4002.
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
     * Päring "4001"
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu
     * sõlminud kaupmeestele. Vastuspaketi kood 3001 või 3002
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
     * Päring "4002"
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu
     * sõlminud kaupmeestele. Vastuspaketi kood 3003.
     */
    protected function create4002()
    {
        $this->addCommonParameters(4002);
        $this->addMacParameter(Constants::SND_ID, Constants::SND_ID_LENGTH, $this->storeId);
        $this->addMacParameter(Constants::REC_ID, Constants::REC_ID_LENGTH);
        $this->addMacParameter(Constants::NONCE, Constants::NONCE_LENGTH, $this->generateNonce());
        $this->addMacParameter(Constants::RETURN_URL, Constants::RETURN_URL_LENGTH, $this->returnUrl);
    }
}
