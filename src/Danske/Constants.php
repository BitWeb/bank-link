<?php
namespace BitWeb\BankLink\Danske;

use BitWeb\BankLink;

/**
 * Constants Pank specific constants
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

    const SND_ID_LENGTH = 14;

    const NAME_LENGTH = 70;

    const REC_NAME_LENGTH = 70;

    const SND_NAME_LENGTH = 70;

    const RETURN_URL_LENGTH = 150;

    const MSG_LENGTH = 210;

    const MAC_LENGTH = 350;

    const REC_ID_LENGTH = 14;

    const BANK_ID = '??';
}
