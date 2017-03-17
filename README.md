bank-link
=========
Banklink and bank related classes.

Usage
=====

## Request construction
~~~~
try {

    $timeNow = new \DateTime();
    $keyPem '';
    $storeId = 'testvpos';
    $returnUrl = 'http://localhost/banklink-return/seb';
    
    $txnId = '1';
    $amount = '0.01';
    $referenceNo = '643519';
    $msg = 'BitWeb test';

    $link = new \BitWeb\BankLink\Seb\Seb();
    $link->setPrivateKey($keyPem);
    $link->setStoreId($storeId);
    $link->setReturnUrl($returnUrl);
    $link->setDatetime($timeNow);
    
    $link->setStamp($txnId);
    $link->setAmount($amount);
    $link->setReferenceNumber($referenceNo);
    $link->setMessage($msg);
    $link->create($service);
                
    $link->create('1012');
    $link->calculateMac();
    
    echo $link->getForm();
    
} catch(Exception $e) {
    print_r($link);
    print_r($e);
}
~~~~

## Bank's return request handling
~~~~
try {
    $bankCertPem = '';

    $link = new \BitWeb\BankLink\Seb\Seb();
    $link->setBankCertificate($bankCertPem);
    
    $link->loadFromReturnRequest();
    
    $link->verifyMac();
    
    switch ($link->getService()) {
        case '3012':
            
            break;
        case '3013':
            $userCountryCode = $link->getValue(\BitWeb\BankLink\Constants::COUNTRY);
            $userName = $link->getValue(\BitWeb\BankLink\Constants::USER_NAME);
            $userPersonalId = $link->getValue(\BitWeb\BankLink\Constants::USER_ID);
            $userOther = $link->getValue(\BitWeb\BankLink\Constants::OTHER);

            $userName = explode(',', $userName);

            $lastname = trim(array_pop($userName));

            $firstname = implode(' ', $userName);
                
            break;
        case '1111':
            // Payment completed.
            // Stamp is generally used for referencing the transaction on client application side.
            $txnId = $link->getValue(\BitWeb\BankLink\Constants::STAMP);
            $amount = $link->getValue(\BitWeb\BankLink\Constants::AMOUNT);
            
            if($link->getValue(\BitWeb\BankLink\Constants::AUTO) == 'N') {
                // User clicked the "Return to merchant" button and was redirected from the bank.
                // Capture the payment and render or rediret user to a success page.
                
            } else {
                /**
                 * Same request can also be duplicated by the bank with VK_AUTO = 'Y'
                 * in case the user didn't click the "Return to merchant" button on bank's site.
                 * We should respond with status 200. Some banks will continue sending automated return requests otherwise.
                 */
                
                die('OK');
            }
                
            break;
        case '1911':
            //Payment canceled by the user
            
            $txnId = $link->getValue(\BitWeb\BankLink\Constants::STAMP);
            
            if($link->getValue(\BitWeb\BankLink\Constants::AUTO) == 'N') {
                // User was redirected from bank
                // Mark the transaction as canceled and render or rediret user to a success page.
                
            } else {
                /**
                 * Same request can also be duplicated by the bank with VK_AUTO = 'Y'
                 * in case the user didn't click the "Return to merchant" button on bank's site.
                 * We should respond with status 200. Some banks will continue resending automatic return requests otherwise.
                 */
                
                die('OK');
            }
            
            break;
    }
} catch(Exception $e) {
    print_r($link);
    print_r($e);
}
~~~~