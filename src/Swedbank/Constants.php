<?php

namespace BitWeb\BankLink\Swedbank;

use BitWeb\BankLink;

abstract class Constants extends BankLink\Constants
{
    const BANK_ID = 'HP';

    const SND_ID_LENGTH = 15;

    const REC_ID_LENGTH = 15;

    const STAMP_LENGTH = 20;

    const T_NO_LENGTH = 20;

    const AMOUNT_LENGTH = 12;

    const REC_ACC_LENGTH = 34;

    const REC_NAME_LENGTH = 70;

    const SND_ACC_LENGTH = 34;

    const SND_NAME_LENGTH = 70;

    const NAME_LENGTH = 70;

    const REF_LENGTH = 35;

    const MSG_LENGTH = 95;

    const RETURN_URL_LENGTH = 255;

    const CANCEL_URL_LENGTH = 255;

    const RID_LENGTH = 30;

    const MAC_LENGTH = 700;

    const USER_LENGTH = 16;

    const USER_NAME_LENGTH = 140;

    const USER_ID_LENGTH = 20;

    const OTHER_LENGTH = 150;
}
