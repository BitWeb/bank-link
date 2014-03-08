<?php

namespace BitWeb\BankLink\Swedbank;

use BitWeb\BankLink;

/**
 *    SwedBank specific parameters
 *
 * @author Tõnis Tobre <tobre@webmedia.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 25, 2009    tobre    Initial version
 */
abstract class Constants extends BankLink\Constants
{

    const SND_ID_LENGTH = 10;
    const REC_ID_LENGTH = 10;
    const MSG_LENGTH = 70;
    const NAME_LENGTH = 30;
    const REC_NAME_LENGTH = 30;
    const SND_NAME_LENGTH = 40;
    const RETURN_URL_LENGTH = 60;
    const BANK_ID = 'HP';
}
