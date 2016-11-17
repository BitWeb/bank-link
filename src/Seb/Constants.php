<?php

namespace BitWeb\BankLink\Seb;

use BitWeb\BankLink;

/**
 * SEB bank specific constants
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

    const SND_ID_LENGTH = 15;

    const NAME_LENGTH = 40;

    const REC_NAME_LENGTH = 40;

    const SND_NAME_LENGTH = 40;

    /**
     * Maksekorralduse selgitus
     */
    const ERROR_CODE = 'VK_ERROR_CODE';
    const ERROR_CODE_LENGTH = 4;

    /**
     * Sõnumi kodeering. Mittekohustuslik parameeter. Lubatud ISO-8859-1(vaikeväärtus) või UTF-8
     */
    const CHARSET = 'VK_CHARSET';
    const CHARSET_LENGTH = 10;

    const RETURN_URL_LENGTH = 60;

    const MSG_LENGTH = 70;

    const MAC_LENGTH = 300;

    const REC_ID_LENGTH = 15;

    const BANK_ID = 'EYP';
}
