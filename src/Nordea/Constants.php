<?php
namespace BitWeb\BankLink\Nordea;
/**
 *
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 29, 2009    tobre    Initial version
 */
class Constants
{

    const VERSION = 'SOLOPMT_VERSION';
    const VERSION_LENGTH = 4;

    const STAMP = 'SOLOPMT_STAMP';
    const STAMP_LENGTH = 20;

    const RCV_ID = 'SOLOPMT_RCV_ID';
    const RCV_ID_LENGTH = 15;

    const RCV_ACCOUNT = 'SOLOPMT_RCV_ACCOUNT';
    const RCV_ACCOUNT_LENGTH = 21;

    const RCV_NAME = 'SOLOPMT_RCV_NAME';
    const RCV_NAME_LENGTH = 30;

    const LANGUAGE = 'SOLOPMT_LANGUAGE';
    const LANGUAGE_LENGTH = 1;

    const AMOUNT = 'SOLOPMT_AMOUNT';
    const AMOUNT_LENGTH = 19;

    const REF = 'SOLOPMT_REF';
    const REF_LENGTH = 20;

    const DATE = 'SOLOPMT_DATE';
    const DATE_LENGTH = 10;

    const MSG = 'SOLOPMT_MSG';
    const MSG_LENGTH = 210;

    const RETURN_URL = 'SOLOPMT_RETURN';
    const RETURN_URL_LENGTH = 60;

    const CANCEL_URL = 'SOLOPMT_CANCEL';
    const CANCEL_URL_LENGTH = 60;

    const REJECT_URL = 'SOLOPMT_REJECT';
    const REJECT_URL_LENGTH = 60;

    const MAC = 'SOLOPMT_MAC';
    const MAC_LENGTH = 32;

    const CONFIRM = 'SOLOPMT_CONFIRM';
    const CONFIRM_LENGTH = 3;

    const KEYVERS = 'SOLOPMT_KEYVERS';
    const KEYVERS_LENGTH = 4;

    const CUR = 'SOLOPMT_CUR';
    const CUR_LENGTH = 3;

    const TIMESTAMP = 'SOLOPMT_TIMESTAMP';
    const TIMESTAMP_LENGTH = 18;

    const RESPTYPE = 'SOLOPMT_RESPTYPE';
    const RESPTYPE_LENGTH = 4;

    const RESPDATA = 'SOLOPMT_RESPDATA';
    const RESPDATA_LENGTH = 120;

    const RESPDETL = 'SOLOPMT_RESPDETL';
    const RESPDETL_LENGTH = 1;

    const ALG = 'SOLOPMT_ALG';
    const ALG_LENGTH = 2;

    const BANK_ID = 'NORDEA';
}
