<?php

namespace BitWeb\BankLink;

/**
 * Class holds information about fields that are sent to bank and received from bank
 *
 * @author Tõnis Tobre <tobre@bitweb.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 25, 2009    tobre    Initial version
 */
abstract class Constants
{

    /**
     * Teenuse number
     */
    const SERVICE = 'VK_SERVICE';
    const SERVICE_LENGTH = 4;

    /**
     * Kasutatav krüptologaritm
     */
    const VERSION = 'VK_VERSION';
    const VERSION_LENGTH = 3;

    /**
     * Päringu ID
     */
    const STAMP = 'VK_STAMP';
    const STAMP_LENGTH = 20;

    /**
     * Maksmisele kuuluv summa
     */
    const AMOUNT = 'VK_AMOUNT';
    const AMOUNT_LENGTH = 17;

    /**
     * Valuuta nimi
     */
    const CURR = 'VK_CURR';
    const CURR_LENGTH = 3;

    /**
     * Saaja konto number
     */
    const ACC = 'VK_ACC';
    const ACC_LENGTH = 20;

    /**
     * Maksekorralduse viitenumber
     */
    const REF = 'VK_REF';
    const REF_LENGTH = 20;

    /**
     * Soovitav suhtluskeel
     */
    const LANG = 'VK_LANG';
    const LANG_LENGTH = 3;

    /**
     * Maksekorralduse number
     */
    const T_NO = 'VK_T_NO';
    const T_NO_LENGTH = 6;

    /**
     * Saaja konto number
     */
    const REC_ACC = 'VK_REC_ACC';
    const REC_ACC_LENGTH = 20;

    /**
     * Maksja konto number
     */
    const SND_ACC = 'VK_SND_ACC';
    const SND_ACC_LENGTH = 20;

    /**
     * Maksekorralduse kuupäev
     */
    const T_DATE = 'VK_T_DATE';
    const T_DATE_LENGTH = 10;

    /**
     * Näitab seda, kas pakett oli saadetud automaatselt (`Y`) või mitte (`N`)
     */
    const AUTO = 'VK_AUTO';
    const AUTO_LENGTH = 1;

    /**
     * Kokkuleppeline kasutaja indifikaator
     */
    const USER = 'VK_USER';
    const USER_LENGTH = 16;

    /**
     * Paketi genereerimise kuupäev
     */
    const DATE = 'VK_DATE';
    const DATE_LENGTH = 10;

    /**
     * Paketi genereerimise kellaaeg
     */
    const TIME = 'VK_TIME';
    const TIME_LENGTH = 8;

    /**
     * Kokkuleppel standardiseeritav kasutaja isikuandmeid sisaldav väli
     */
    const INFO = 'VK_INFO';
    const INFO_LENGTH = 300;

    /**
     * Oodatava vastuspaketi kood
     */
    const REPLY = 'VK_REPLY';
    const REPLY_LENGTH = 4;

    /**
     * Sõnumi koostaja (partneri) ID
     */
    const SND_ID = 'VK_SND_ID';

    /**
     * Saaja nimi
     */
    const NAME = 'VK_NAME';

    /**
     * Maksekorralduse seletus
     */
    const MSG = 'VK_MSG';

    /**
     * Kontrollkood e. allkiri
     */
    const MAC = 'VK_MAC';
    const MAC_LENGTH = 700;

    /**
     * URL, kuhu vastatakse edukal tehingu sooritamisel
     */
    const RETURN_URL = 'VK_RETURN';

    /**
     * Saaja nimi
     */
    const REC_NAME = 'VK_REC_NAME';

    /**
     * Maksja nimi
     */
    const SND_NAME = 'VK_SND_NAME';

    /**
     * Päringu vastuvõtja ID (Kaupluse ID)
     */
    const REC_ID = 'VK_REC_ID';

    /**
     * URL, kuhu vastatakse ebaõnnestunud tehingu puhul
     */
    const CANCEL_URL = 'VK_CANCEL';
    const CANCEL_URL_LENGTH = 60;

    /**
     *
     * Päringu saatja poolt genereeritud juhuslik nonss (kasutatakse värskuse tagamiseks)
     */
    const NONCE = 'VK_NONCE';
    const NONCE_LENGTH = 50;

}
