<?php
namespace BitWeb\BankLink;

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
    const AMOUNT_LENGTH = 12;

    /**
     * Valuuta nimi
     */
    const CURR = 'VK_CURR';
    const CURR_LENGTH = 3;

    /**
     * Saaja konto number
     */
    const ACC = 'VK_ACC';
    const ACC_LENGTH = 34;

    /**
     * Maksekorralduse viitenumber
     */
    const REF = 'VK_REF';
    const REF_LENGTH = 35;

    /**
     * Soovitav suhtluskeel
     */
    const LANG = 'VK_LANG';
    const LANG_LENGTH = 3;

    /**
     * Maksekorralduse number
     */
    const T_NO = 'VK_T_NO';
    const T_NO_LENGTH = 20;

    /**
     * Saaja konto number
     */
    const REC_ACC = 'VK_REC_ACC';
    const REC_ACC_LENGTH = 34;

    /**
     * Maksja konto number
     */
    const SND_ACC = 'VK_SND_ACC';
    const SND_ACC_LENGTH = 34;

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
    const CANCEL_URL_LENGTH = 255;

    /**
     *
     * Päringu saatja poolt genereeritud juhuslik nonss (kasutatakse värskuse tagamiseks)
     */
    const NONCE = 'VK_NONCE';
    const NONCE_LENGTH = 50;

    const DATETIME = 'VK_DATETIME';
    const DATETIME_LENGTH = 24;

    const T_DATETIME = 'VK_T_DATETIME';
    const T_DATETIME_LENGTH = 24;

    const RID = 'VK_RID';
    const RID_LENGTH = 30;

    const USER_NAME = 'VK_USER_NAME';
    const USER_NAME_LENGTH = 140;

    const USER_ID = 'VK_USER_ID';
    const USER_ID_LENGTH = 20;

    /*
     * Isikukoodi riik (kahetäheline kood vastavalt ISO 3166-1 standardile)
     */
    const COUNTRY = 'VK_COUNTRY';
    const COUNTRY_LENGTH = 2;

    const OTHER = 'VK_OTHER';
    const OTHER_LENGTH = 150;

    /*
     * Autentimisvahendi identifikaatori kood:
     * 1- ID-kaart;
     * 2- Mobiil-ID;
     * 5- ühekordsed koodid v.a. PIN-kalkulaator (Swedbank hetkel ühekordseid paroole ei kasuta);
     * 6- PIN-kalkulaator;
     * 7- korduvkasutusega kaart
     */
    const TOKEN = 'VK_TOKEN';
    const TOKEN_LENGTH = 2;

    /*
     * Sõnumi kodeering. UTF-8 (vaikeväärtus), ISO-8859-1 või WINDOWS-1257
     */
    const ENCODING = 'VK_ENCODING';
    const ENCODING_LENGTH = 12;

}
