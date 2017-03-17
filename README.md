bank-link
=========
Banklink and bank related classes.

Usage
=====

## Request construction
~~~~
$sebTestUrl = 'https://www.seb.ee/cgi-bin/dv.sh/ipank.r';

$sebTestMerchantKeyPem '-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC+AROlXiRvi1T7Q9fAh0Lw73szAn26mqfKDqd6Bdplq3v+gVWC
3v0+bgtfNakRE/UVYOxEA0z0viqRpKzPuNy8OstTMe8fFKs19NW8lBYik6NzJ4Bk
+B6VmovOm0nJLQJytXKiJyuHP9DqPOVmP8S+azzX7Uqzov1nxo9fvH7y2QIDAQAB
AoGAFhbD9O6r57fYCloJxB01gBMnTHfWrBH8vbXUbJAvorA7+wuIKG3KHS7n7Yqs
fArI7FJXRVTo5m8RPdtaJ9ADAT9rjAi3A17TaEueyJl+B/hjHYhsd8MeFhTb2fh0
rY3F6diL8U/YDbiAIegnKO0zcc6ynJrsQZvzb6DlY/CLPe0CQQD3KXJzw1ZfJ1ts
c370b/ZC1YrRURw41Q0I8ljYJ8EJw/ngVxrnCIsd43bRnOVp9guJrjTQRkhDC3Gn
J2Y0+42LAkEAxMxmh7QY4nItBTS0fe1KCat4VDxhyxYEhZKlGDhxW75vNROrripB
1ZfBsq5xkY2MM9R7WKmL7SpStrUPIvEVqwJBAOXA4ISd61cupbytrDEbNscv7Afh
pyNpYOGVLmNYqQgj5c7WCcsD1RYmkRgPCe8y6czFZJDLFHdGVxLz+/16bTsCQC9J
Ob2TnYMTkhO1JUU4tdh69e+vjoPgp3d80+Rs83fq2wey0UaI6saqryUC21Dw5OYz
QOv92RxEVhmGibuIl/8CQCiYrzwlZJDlsKrWPZT0E8rzNmLZkhNHzYJP9S7x+FKk
m3gFeXEBgzGn9UOd6xIAp0p7A1XVBN8XzDMa09gSOks=
-----END RSA PRIVATE KEY-----
';

try {

    $timeNow = new \DateTime();
    //Seb test merchant key
    $keyPem = $sebTestMerchantKeyPem;
    $storeId = 'testvpos';
    $returnUrl = 'http://localhost/banklink-return/seb';
    
    $txnId = '1';
    $amount = '0.01';
    $referenceNo = '643519';
    $msg = 'BitWeb test';

    $link = new \BitWeb\BankLink\Seb\Seb();
    $link->setUrl($sebTestUrl);
    $link->setPrivateKey($keyPem);
    $link->setStoreId($storeId);
    $link->setReturnUrl($returnUrl);
    $link->setDatetime($timeNow);
    
    $link->setStamp($txnId);
    $link->setAmount($amount);
    $link->setReferenceNumber($referenceNo);
    $link->setMessage($msg);
                
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
$sebTestBankCertPem = '-----BEGIN CERTIFICATE-----
MIIDRTCCAq6gAwIBAgIBADANBgkqhkiG9w0BAQQFADB7MQswCQYDVQQGEwJFRTEO
MAwGA1UECBMFSGFyanUxEDAOBgNVBAcTB1RhbGxpbm4xDDAKBgNVBAoTA0VZUDEL
MAkGA1UECxMCSVQxDDAKBgNVBAMTA2EuYTEhMB8GCSqGSIb3DQEJARYSYWxsYXIu
YWxsYXNAZXlwLmVlMB4XDTk5MTExNTA4MTAzM1oXDTk5MTIxNTA4MTAzM1owezEL
MAkGA1UEBhMCRUUxDjAMBgNVBAgTBUhhcmp1MRAwDgYDVQQHEwdUYWxsaW5uMQww
CgYDVQQKEwNFWVAxCzAJBgNVBAsTAklUMQwwCgYDVQQDEwNhLmExITAfBgkqhkiG
9w0BCQEWEmFsbGFyLmFsbGFzQGV5cC5lZTCBnzANBgkqhkiG9w0BAQEFAAOBjQAw
gYkCgYEAvgETpV4kb4tU+0PXwIdC8O97MwJ9upqnyg6negXaZat7/oFVgt79Pm4L
XzWpERP1FWDsRANM9L4qkaSsz7jcvDrLUzHvHxSrNfTVvJQWIpOjcyeAZPgelZqL
zptJyS0CcrVyoicrhz/Q6jzlZj/Evms81+1Ks6L9Z8aPX7x+8tkCAwEAAaOB2DCB
1TAdBgNVHQ4EFgQUFivCzZNmegEoOxYtg20YMMRB98gwgaUGA1UdIwSBnTCBmoAU
FivCzZNmegEoOxYtg20YMMRB98ihf6R9MHsxCzAJBgNVBAYTAkVFMQ4wDAYDVQQI
EwVIYXJqdTEQMA4GA1UEBxMHVGFsbGlubjEMMAoGA1UEChMDRVlQMQswCQYDVQQL
EwJJVDEMMAoGA1UEAxMDYS5hMSEwHwYJKoZIhvcNAQkBFhJhbGxhci5hbGxhc0Bl
eXAuZWWCAQAwDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQQFAAOBgQBfkayuot+e
fwW8QmPwpWF5AY3oMT/fTncjCljDBOg39IQv4PjnpTdDfwwl3lUIZHHTLM2i0L/c
eD4D1UFM1qdp2VZzhBd1eeMjxYjCP8qL2v2MfLkCYcP30Sl6ISSkFjFc5qbGXZOc
C82uR/wUZJDw9kj+R1O46/byG8yA+S9FVw==
-----END CERTIFICATE-----
';

try {
    $timeNow = new \DateTime();

    $bankCertPem = $sebTestBankCertPem;

    $link = new \BitWeb\BankLink\Seb\Seb();
    $link->setBankCertificate($bankCertPem);
    
    $link->loadFromReturnRequest();
    
    $link->verifyMac();
    
    switch ($link->getService()) {
        case '3012':
            //Return result for authentication service 4011
            
            break;
        case '3013':
            //Return result for authentication service 4012
            
            $messageDatetime = $link->getValue(\BitWeb\BankLink\Constants::DATETIME);
            $messageDatetime = \DateTime::createFromFormat(\DateTime::ISO8601, $messageDatetime);
            $diff = $timeNow->getTimestamp() - $messageDatetime->getTimestamp();
            if($diff > 300) throw new Exception('Authentication return request expired.');
            
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
                 * in case the user didn't click the "Return to merchant" button in the bank.
                 * We should respond with status 200. Some banks will continue resending automated return requests otherwise.
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
                 * in case the user didn't click the "Return to merchant" button in the bank.
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