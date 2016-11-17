<?php
namespace BitWeb\BankLink\Krediidipank;

use BitWeb\BankLink;

/**
 *
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

    const VK_SND_ID_LENGTH = 15;
    const VK_REC_ID_LENGTH = 15;
    const VK_MSG_LENGTH = 70;
    const VK_REC_NAME_LENGTH = 30;
    const VK_SND_NAME_LENGTH = 30;
    const VK_RETURN_URL_LENGTH = 200;
    const VK_CANCEL_URL_LENGTH = 200;

    const BANK_ID = 'Krediidipank';
}
