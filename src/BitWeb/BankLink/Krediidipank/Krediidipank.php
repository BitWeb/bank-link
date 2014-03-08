<?php

namespace BitWeb\BankLink\Krediidipank;

use BitWeb\BankLink\BankLink;

/**
 * Krediidipank specific bank link creating class
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 24, 2009    tobre    Initial version
 */
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

    /* (non-PHPdoc)
     * @see BankLink/BankLink#setSpecificParameters()
     */
    protected function setSpecificParameters()
    {
        $this->addParameter(Constants::MAC, Constants::MAC_LENGTH);
    }

    /**
     * Kaupmees saadab (7) kliendi päringuga panka allkirjastatud maksekorralduse
     * andmed, mida klient internetipangas muuta ei saa. Makse saaja nimi ja konto number
     * võtab pank panga ja kaupmehe vahelisest lepingust.
     * Peale edukat makset koostatakse kaupmehele päring "1101" (12), ebaõnnestunud
     * makse puhul pakett "1901". Internetipanga server püüab alati oma serverist saata ka
     * vastuse rezhiimiga VK_AUTO=’Y’, seda juhtudeks kui kliendi seanss katkeb või
     * klient ei liigu korrektselt tagasi kaupmehe veebileheküljele.
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
        $this->addParameter(Constants::LANG, Constants::LANG_LENGTH, $this->language);
    }

    /**
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
    }

    /**
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
     * Kasutaja pöördub panka (1). Pank palub kasutajal ennast identifitseerida (2). Pärast
     * positiivset kasutajatunnuste sisestamist (3) pakutakse kasutajale võimalust kasutada
     * erinevaid pangateenuseid (4), millest üks on sisenemine Portaali (5).
     * Pärast seda, kui kasutaja on teavitanud panka, et ta soovib kasutada Portaali teenuseid,
     * produtseerib pank sõnumi 3002 (6), mis signeeritakse (7) ja saadetakse kasutaja
     * brauseri päise kaudu (8) edasi Portaali (9). Seejärel jätkub tegevus juba sarnaselt
     * meetodis 1 kirjeldatud teed pidi.
     * Peab siiski märkima, et Ajapitseri kontrollimine käib selles meetodis mõnevõrra
     * teistmoodi: erinevalt eelmisest meetodist, ei saadeta kontrollaega päringuga 4002,
     * vaid selle genereerib pank. Kui panga ja Portaali serverikellaaegade erinevus läheb
     * piisavalt suureks, siis võib tekkida olukord, et tühistatakse kõik sisenemised, mis on
     * saabunud sellest ettevõttest. Et seda vältida, valivad Portaal ja Pank aja
     * sünkroniseerimiseks ühe Internetis ajastandardi teenust pakkuvatest institutsioonidest,
     * kelle tuumakella loetakse sõnumi ajapitseri (VK_TIME ja VK_DATE) koostamisel
     * kohustuslikuks.
     */
    protected function create3002()
    {
        $this->addCommonParameters(3002);
        $this->addMacParameter(Constants::VK_USER, Constants::VK_USER_LENGTH);
        $this->addMacParameter(Constants::VK_DATE, Constants::VK_DATE_LENGTH);
        $this->addMacParameter(Constants::VK_TIME, Constants::VK_TIME_LENGTH);
        $this->addMacParameter(Constants::VK_SND_ID, Constants::VK_SND_ID_LENGTH);
        $this->addMacParameter(Constants::VK_INFO, Constants::VK_INFO_LENGTH);
    }

    /**
     * Kaupmehele edastatakse kasutaja isikukood ja nimi
     */
    protected function create3003()
    {
        $this->addCommonParameters(3003);
        $this->addMacParameter(Constants::VK_SND_ID, Constants::VK_SND_ID_LENGTH);
        $this->addMacParameter(Constants::VK_REC_ID, Constants::VK_REC_ID_LENGTH);
        $this->addMacParameter(Constants::VK_NONCE, Constants::VK_NONCE_LENGTH);
        $this->addMacParameter(Constants::VK_INFO, Constants::VK_INFO_LENGTH);
    }

    /**
     * Autentimispäringu 4001 väljad:
     * NB! Autentimise realiseerimisel soovitame tungivalt kasutada ajapitserist sõltumatut
     * (4002->3003) varianti, sest siis ei teki probleeme kellade keeramise hetkedel.
     */
    protected function create4001()
    {
        $this->addCommonParameters(4001);
        $this->addMacParameter(Constants::VK_SND_ID, Constants::VK_SND_ID_LENGTH);
        $this->addMacParameter(Constants::VK_REPLY, Constants::VK_REPLY_LENGTH);
        $this->addMacParameter(Constants::VK_RETURN, Constants::VK_RETURN_LENGTH);
        $this->addMacParameter(Constants::VK_DATE, Constants::VK_DATE_LENGTH);
        $this->addMacParameter(Constants::VK_TIME, Constants::VK_TIME_LENGTH);
    }

    /**
     * Portaal genereerib kasutaja poolt valitud panga jaoks sõnumi 4002 (4) ja signeerib
     * selle (5). Samaaegselt salvestatakse genereeritud sõnum ka vahetabelisse.
     * Genereeritud ja signeeritud sõnum 4002 saadetakse ootavale kasutajale (6), kus
     * kuvatakse nupp Autendime mispeale suunatakse kasutaja edasi internetipanka (7).
     * Asjakohane näide on ära toodud lisas 3 – HTTP(S) kanali kasutamine.
     * Pank, pärast signatuuri kontrolli (8) palub kasutajal ennast sisse logida (9). Kui
     * kasutaja on edukalt panka sisenenud (10), siis koostab pank vastussõnumi: 3003 (11).
     * Sarnaselt sõnumile 4002 see signeeritakse (12) ning edastatakse kasutajale (13),
     * misjärel viimane suunatakse tagasi Portaali (14).
     * Portaal kontrollib edastatud sõnumi signatuuri (15). Kui signatuur on tõene, siis
     * kontrollitakse, kas vastus 3003 on saabunud eelnevalt saadetud sõnumile (4002)
     * etteantud ajaliimid piires (16) ja seejärel vaadatakse, kas antud kasutaja isikukood on
     * kasutusel (17). Portaal kasutab klientide identifikaatorina isikukoodi.
     *
     * Autentimispäringu 4002 väljad:
     */
    protected function create4002()
    {
        $this->addCommonParameters(4002);
        $this->addMacParameter(Constants::VK_SND_ID, Constants::VK_SND_ID_LENGTH);
        $this->addMacParameter(Constants::VK_REC_ID, Constants::VK_REC_ID_LENGTH);
        $this->addMacParameter(Constants::VK_NONCE, Constants::VK_NONCE_LENGTH);
        $this->addMacParameter(Constants::VK_RETURN, Constants::VK_RETURN_LENGTH);
    }
}
