<?php

namespace BitWeb\BankLink;

abstract class BankLink
{
    /**
     * Banklink url
     * @var string
     */
    protected $url;

    /**
     * MAC version. Always '008'
     * @var string
     */
    protected $version = '008';

    /**
     * Valuuta. Always 'EUR'
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * Sõnumi kodeering. UTF-8 (vaikeväärtus), ISO-8859-1 või WINDOWS-1257
     * @var string
     */
    protected $encoding = 'UTF-8';

    /**
     * Soovitud kasutajaliidese keel (EST, ENG või RUS)
     * @var string
     */
    protected $language = 'EST';

    /**
     * Client ID
     * @var string
     */
    protected $storeId;

    /**
     * Client account number
     * @var string
     */
    protected $accountNumber;

    /**
     * Reference number
     * @var string
     */
    protected $referenceNumber;

    /**
     * Selgitus
     * @var $message
     */
    protected $message;

    /**
     * Payment amount
     * @var string
     */
    protected $amount;

    /**
     * URL where user is redirected after payment
     * @var string
     */
    protected $returnUrl;

    /**
     * Payment stamp
     * @var string
     */
    protected $stamp = '1';

    /**
     * @var string
     */
    protected $rid = '';

    /**
     * @var \DateTime
     */
    protected $datetime = null;

    /**
     * Client name
     * @var string
     */
    protected $clientName;

    /**
     * Bank id
     * @var string
     */
    protected $bankId;

    /**
     * Client private key
     * @var string
     */
    private $privateKey;

    /**
     * Bank public key
     * @var string
     */
    private $bankCertificte;

    /**
     * Passphrase for client private key
     * @var string
     */
    private $passPhrase;

    /**
     * Service parameters
     * @var array
     */
    private $parameters = array();

    /**
     * Serivce parameters included in MAC calculation
     * @var array
     */
    private $macParameters = array();

    /**
     * Constructor for seting private and public keys
     * @param string $privateKey Client private key
     * @param string $bankCertificate Bank public key
     */
    public function __construct($privateKey = null, $bankCertificate = null)
    {
        $this->privateKey = $privateKey;
        $this->bankCertificte = $bankCertificate;
    }

    /**
     * Generates uniq nonce value
     * @return string Unique nonce
     */
    public static function generateNonce()
    {
        return sha1(uniqid(rand(), true));
    }

    /**
     * Swedbank 22 or 11
     * SEB 10
     * Sampo 33
     * Nordea 17
     * Krediidipank 42
     * Citadele Pank 12
     * LHV Pank 77
     * Bank DnB NORD 96
     * Tallinna Äripank 93
     * @param string $accountNumber
     * @return string
     */
    public static function getBankNameByAccountNumber($accountNumber) {
        $numbers = (int)substr($accountNumber, 0, 2);

        switch ($numbers) {
            case 22:
            case 11:
                return 'Swedbank';
            case 10:
                return 'SEB';
            case 33:
                return 'Danske';
            case 17:
                return 'Nordea';
            case 42:
                return 'Krediidipank';
            case 16:
                return 'Eesti Pank';
            case 55:
                return 'Versobank';
            case 12:
                return 'Citadele Pank';
            case 77:
                return 'LHV Pank';
            case 83:
                return 'Svenska Handelsbanken';
            case 51:
                return 'Pohjola Bank plc Eesti filiaal';
            case 96:
                return 'Bank DnB NORD';
            case 93:
                return 'Tallinna Äripank';
            case 75:
                return 'BIGBANK AS';
            default:
                return 'Unknown';
        }
    }

    public static function getBankNameByIban($iban) {
        if ($iban == '' or $iban == null) {
            return 'Unknown';
        }
        $numbers = (int)substr($iban, 4, 2);

        switch ($numbers) {
            case 22:
                return 'Swedbank';
            case 16:
                return 'Eesti Pank';
            case 10:
                return 'SEB';
            case 33:
                return 'Danske';
            case 17:
                return 'Nordea';
            case 12:
                return 'Citadele Pank';
            case 55:
                return 'Versobank';
            case 42:
                return 'Krediidipank';
            case 83:
                return 'Svenska Handelsbanken';
            case 51:
                return 'Pohjola Bank plc Eesti filiaal';
            case 77:
                return 'LHV Pank';
            case 75:
                return 'BIGBANK';
            case 96:
                return 'DNB Pank';
            case '00':
                return 'Tallinna Äripank';
            default:
                return 'Unknown';
        }
    }

    public static function calculateRefNoChecksum($refNo) {
        $refNo = (string)$refNo;
        $weights = [7,3,1];
        $sl = $st = strlen($refNo);
        $total = 0;
        while($sl > 0 and substr($refNo, --$sl, 1) >='0'){
            $total += substr($refNo, ($st-1)-$sl, 1)* $weights[($sl%3)];
        }
        $checksum = ((ceil(($total/10))*10)-$total);
        return $checksum;
    }

    public static function validateReferenceNumber($refNo) {
        if(empty($refNo)) {
            return false;
        }
        if (!preg_match('/^[0-9]+$/', $refNo)) {
            return false;
        }
        if(strlen($refNo) > 20) {
            return false;
        }

        $inputChecksum = $refNo[strlen($refNo) - 1];
        $checksum = self::calculateRefNoChecksum(substr($refNo, 0, strlen($refNo) - 1));

        if($inputChecksum != $checksum) {
            return false;
        }

        return true;
    }

    /**
     * @link http://www.pangaliit.ee/et/arveldused/7-3-1meetod
     *
     * @param $nr
     * @return string
     */
    public static function generateReferenceNumber($nr)
    {
        $nr = (string)$nr;
        $kaal = array(7, 3, 1);
        $sl = $st = strlen($nr);
        $total = 0;
        while ($sl > 0 and substr($nr, --$sl, 1) >= '0') {
            $total += substr($nr, ($st - 1) - $sl, 1) * $kaal[($sl % 3)];
        }
        $kontrollnr = ((ceil(($total / 10)) * 10) - $total);

        return $nr . $kontrollnr;
    }

    protected static function getParameterLength($fieldName) {
        $fieldName = str_replace('VK_', '', $fieldName);
        return constant(Constants::class.'::'.$fieldName.'_LENGTH');
    }

    /**
     * Setting bank request parameter
     * @param string $field Parameter field field name
     * @param string $value Parameter value
     * @return BankLink object
     */
    public function setParameter($field, $value)
    {
        $this->parameters[$field] = new Parameter($field, $value);
        return $this;
    }

    /**
     * Getting parameter object by field name
     * @param string $field Parameter field name
     * @return Parameter object
     */
    public function getParameter($field)
    {
        return $this->parameters[$field];
    }

    /**
     * (non-PHPdoc)
     * @see BankLink#setParameter()
     */
    public function setValue($field, $value)
    {
        return $this->setParameter($field, $value);
    }

    /**
     * Gets value by parameter field name
     * @param string $field Parameter field name
     * @return Parameter value
     * @see BankLink#getParameter()
     */
    public function getValue($field)
    {
        return $this->getParameter($field)->getValue();
    }

    /**
     * Gets bankId
     */
    public function getBankId()
    {
        return $this->bankId;
    }

    public function getService() {
        return $this->parameters[Constants::SERVICE]->getValue();
    }

    /**
     * Sets client private key for signing operation
     * @param string $privateKey Client private key path
     * @return BankLink object
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
        return $this;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Sets bank public key for verifying operation
     * @param string $bankCertificate PEM encoded bank's public key
     * @return BankLink object
     */
    public function setBankCertificate($bankCertificate)
    {
        $this->bankCertificte = $bankCertificate;
        return $this;
    }

    /**
     * Sets passphrase for accessing client private key
     * @param string $passPhrase Passphrase
     * @return BankLink object
     */
    public function setPassPhrase($passPhrase)
    {
        $this->passPhrase = $passPhrase;
        return $this;
    }

    /**
     * Setting aternative bank URL where to submit
     * @param string $url Bank URL
     * @return BankLink object
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Gets bank URL where to submit
     * @return string URL
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets MAC version
     * @param string $version MAC version
     * @return BankLink object
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Sets currency
     * @param string $currency Currency
     * @return BankLink object
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param string $encoding
     * @return BankLink object
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * @param string $language
     * @return BankLink object
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Prepares request parameters for MAC calculation
     * @param string $service Service that is used for current action
     * @throws Exception when there are no such method
     */
    public function prepareService($service) {
        $method = 'create' . $service;
        if (!method_exists($this, $method)) {
            throw new Exception('No such method "' . $method . '"');
        }

        $this->$method();
    }

    /**
     * Creates request and response methods for communicating bank
     * @param integer $service Service that is used for current action
     * @throws Exception when there are no such method
     */
    public function create($service)
    {
        $this->prepareService($service);

        $this->calculateMac();
    }

    /**
     * Gets right response method and load right values request
     */
    public function createFromReturnRequest()
    {
        $this->loadParameters($_REQUEST);
        $this->prepareService($this->parameters[Constants::SERVICE]->getValue());

        $this->verifyMac();
    }

    /**
     * Checks if bank has accepted payment
     * @param boolean $response Response from bank
     * @return true if bank has accepted, false otherwise
     */
    public function isAccepted($response)
    {
        return !$response;
    }

    /**
     * Sets client ID that is registered in bank
     * @param string $storeId Client ID
     * @return BankLink object
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * Sets client account number
     * @param string $accountNumber Client account number
     * @return BankLink object
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * Sets client reference number
     * @param string $referenceNumber Client reference number
     * @return BankLink object
     */
    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
        return $this;
    }

    /**
     * Sets message to payment
     * @param string $message Message text
     * @return BankLink object
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Sets amount of money
     * @param string $amount Money amount
     * @return BankLink object
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Sets return URL when coming back from bank. Return URL is also Cancel URL
     * @param string $returnUrl URL where user reached from bank
     * @return BankLink object
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * Sets payment stamp
     * @param string $stamp Payment stamp
     * @return BankLink object
     */
    public function setStamp($stamp)
    {
        $this->stamp = $stamp;
        return $this;
    }

    public function setRid($rid) {
        $this->rid = $rid;
        return $this;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * Sets Client name
     * @param string $clientName Client name
     * @return BankLink object
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
        return $this;
    }

    /**
     * Get fields that are needed to submitting
     * @return array of fields
     */
    final public function getFields()
    {
        $fields = array();
        foreach ($this->parameters as $parameter) {
            $fields[$parameter->getField()] = $parameter->getFormattedValue();
        }
        return $fields;
    }

    final public function getForm()
    {
        $formHTML = '<html><body>';
        $formHTML .= '<form id="bankForm" method="POST" action="' . $this->url . '">' . PHP_EOL;
        $formHTML .= $this->renderFields();
        $formHTML .= '</form>';
        $formHTML .= '<script type="text/javascript">document.getElementById("bankForm").submit();</script></body></html>';
        return $formHTML;
    }

    /**
     * Adds parameter that is included in MAC calculation
     * @param string $field Parameter field
     * @param $defaultValue Parameter default value
     * @see BankLink#addParameter()
     */
    final protected function addMacParameter($field, $defaultValue = null)
    {
        $this->macParameters[] = $field;
        $this->addParameter($field, $defaultValue);
    }

    /**
     * Adds parameter to service method
     * @param string $field Parameter field
     * @param string $length Parameter length
     * @param string $defaultValue Parameter default value
     */
    final protected function addParameter($field, $defaultValue = null)
    {
        if (isset($this->parameters[$field]) && $this->parameters[$field] instanceof Parameter) {
            $this->parameters[$field]->setLength(static::getParameterLength($field));
        } else {
            $this->parameters[$field] = new Parameter($field, $defaultValue, static::getParameterLength($field));
        }
    }

    /**
     * Adds common parameters that is common for all service methods
     * @param string $service Method number
     */
    protected function addCommonParameters($service)
    {
        $this->addMacParameter(Constants::SERVICE, $service);
        $this->addMacParameter(Constants::VERSION, $this->version);
        $this->addParameter(Constants::MAC);
        $this->addParameter(Constants::ENCODING, $this->encoding);
        $this->addParameter(Constants::LANG, $this->language);
    }

    /**
     * Calculates MAC value over client private key and sets it
     * @throws Exception when signing fails
     * @return string MAC signature
     */
    public function calculateMac()
    {
        $privateKeyContents = $this->privateKey;
        $privateKey = openssl_get_privatekey($privateKeyContents, $this->passPhrase);

        $signature = null;
        $isSigned = openssl_sign($this->getMacSource(), $signature, $privateKey);

        openssl_free_key($privateKey);

        if (!$isSigned) {
            throw new Exception('Signing failed');
        }

        $signature = base64_encode($signature);
        $this->parameters[Constants::MAC]->setValue($signature);

        return $signature;
    }

    /**
     * Verifies MAC if response is came from bank
     * @throws Exception when verifyng failed
     */
    public function verifyMac()
    {
        $certificate = $this->bankCertificte;

        $publicKeyId = openssl_get_publickey($certificate);
        $isVerified = openssl_verify($this->getMacSource(), base64_decode($this->parameters[Constants::MAC]->getFormattedValue()), $publicKeyId);
        openssl_free_key($publicKeyId);
        if (!$isVerified) {
            throw new Exception('Verifying failed');
        }
    }

    /**
     * Calculates MAC source by mandatory values
     * @return string MAC source
     */
    private function getMacSource()
    {
        $data = '';
        foreach ($this->macParameters as $macParameter) {
            $value = $this->parameters[$macParameter]->getFormattedValue();
            if (null === $value) {
                throw new Exception('"' . $macParameter . '" has to be setted');
            }
            $data .= str_pad(mb_strlen($value, 'UTF-8'), 3, '0', STR_PAD_LEFT) . $value;
        }
        return $data;
    }

    /**
     * Load values from request. And sets into parameters
     * @param array $data Where to load values. Default is $_REQUEST
     * @see BankLink#setParameter()
     */
    public function loadParameters(array $data = null)
    {
        if (null === $data) {
            $data = $_REQUEST;
        }
        foreach ($data as $field => $value) {
            $this->setParameter($field, $value);
        }
    }

    /**
     * Renders neccessary fields for the hidden redirect form
     * @return string Fields HTML code
     */
    private function renderFields()
    {
        $fieldsHTML = '';
        foreach ($this->getFields() as $field => $value) {
            $fieldsHTML .= '<input type="hidden" name="' . $field . '" value="' . $value . '" />' . PHP_EOL;
        }
        return $fieldsHTML;
    }

    protected function getMacParameters()
    {
        return $this->macParameters;
    }

    /**
     * Teenus 1011
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient internetipangas muuta ei saa.
     * Pärast edukat makset koostatakse kaupmehele päring “1111”, ebaõnnestunud makse puhul “1911”
     */
    protected function create1011()
    {
        $this->addCommonParameters('1011');
        $this->addMacParameter(Constants::SND_ID       ,$this->storeId);
        $this->addMacParameter(Constants::STAMP        ,$this->stamp);
        $this->addMacParameter(Constants::AMOUNT       ,number_format($this->amount, 2, '.', ''));
        $this->addMacParameter(Constants::CURR         ,$this->currency);
        $this->addMacParameter(Constants::ACC          ,$this->accountNumber);
        $this->addMacParameter(Constants::NAME         ,$this->clientName);
        $this->addMacParameter(Constants::REF          ,$this->referenceNumber);
        $this->addMacParameter(Constants::MSG          ,$this->message);
        $this->addMacParameter(Constants::RETURN_URL   ,$this->returnUrl);
        $this->addMacParameter(Constants::CANCEL_URL   ,$this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, '');
        }
    }

    /**
     * Teenus 1012
     * Kaupmees saadab panka allkirjastatud maksekorralduse andmed, mida klient internetipangas muuta ei saa.
     * Pärast edukat makset koostatakse kaupmehele päring “1111”, ebaõnnestunud makse puhul “1911”
     */
    protected function create1012()
    {
        $this->addCommonParameters('1012');
        $this->addMacParameter(Constants::SND_ID        ,$this->storeId);
        $this->addMacParameter(Constants::STAMP         ,$this->stamp);
        $this->addMacParameter(Constants::AMOUNT        ,number_format($this->amount, 2, '.', ''));
        $this->addMacParameter(Constants::CURR          ,$this->currency);
        $this->addMacParameter(Constants::REF           ,$this->referenceNumber);
        $this->addMacParameter(Constants::MSG           ,$this->message);
        $this->addMacParameter(Constants::RETURN_URL    ,$this->returnUrl);
        $this->addMacParameter(Constants::CANCEL_URL    ,$this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, '');
        }
    }

    /**
     * Teenus 1111
     * Vastus Tehingu aktsepteerimise kohta
     */
    protected function create1111()
    {
        $this->addCommonParameters('1111');
        $this->addMacParameter(Constants::SND_ID);
        $this->addMacParameter(Constants::REC_ID);
        $this->addMacParameter(Constants::STAMP);
        $this->addMacParameter(Constants::T_NO);
        $this->addMacParameter(Constants::AMOUNT);
        $this->addMacParameter(Constants::CURR);
        $this->addMacParameter(Constants::REC_ACC);
        $this->addMacParameter(Constants::REC_NAME);
        $this->addMacParameter(Constants::SND_ACC);
        $this->addMacParameter(Constants::SND_NAME);
        $this->addMacParameter(Constants::REF);
        $this->addMacParameter(Constants::MSG);
        $this->addMacParameter(Constants::T_DATETIME);
        $this->addParameter(Constants::LANG);
        $this->addParameter(Constants::AUTO);
    }

    /**
     * Teenus 1911
     * Kasutatakse ebaõnnestunud tehingust teatamiseks.
     */
    protected function create1911()
    {
        $this->addCommonParameters('1911');
        $this->addMacParameter(Constants::SND_ID);
        $this->addMacParameter(Constants::REC_ID);
        $this->addMacParameter(Constants::STAMP);
        $this->addMacParameter(Constants::REF);
        $this->addMacParameter(Constants::MSG);
        $this->addParameter(Constants::LANG);
        $this->addParameter(Constants::AUTO);
    }


    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3012.
     */
    protected function create4011() {
        $this->addCommonParameters('4011');
        $this->addMacParameter(Constants::SND_ID, $this->storeId);
        $this->addMacParameter(Constants::REPLY, '3012');
        $this->addMacParameter(Constants::RETURN_URL, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, '');
        }
        $this->addMacParameter(Constants::RID, '');
    }

    /*
     * Kaupmehele edastatakse info kasutaja kohta ning paketi genereerimise kuupäev ja kellaaeg. Turvalisuse huvides peab
     * kaupmees kontrollima paketis olevat saatmise aega (VK_DATETIME). Väli VK_USER_NAME sisaldab kasutaja nime kujul
     * „perekonnanimi,eesnimi“ (näiteks: SAAR,JAAN).
     */
    protected function create3012() {
        $this->addCommonParameters('3012');
        $this->addMacParameter(Constants::USER);
        $this->addMacParameter(Constants::DATETIME);
        $this->addMacParameter(Constants::SND_ID);
        $this->addMacParameter(Constants::REC_ID);
        $this->addMacParameter(Constants::USER_NAME);
        $this->addMacParameter(Constants::USER_ID);
        $this->addMacParameter(Constants::COUNTRY);
        $this->addMacParameter(Constants::OTHER);
        $this->addMacParameter(Constants::TOKEN);
        $this->addMacParameter(Constants::RID);
    }

    /*
     * Kaupmehe poolt saadetav pakett kasutaja tuvastamiseks. Teenus avatud vastava lepingu sõlminud kaupmeestele.
     * Vastuspaketi kood 3013.
     */
    protected function create4012() {
        $this->addCommonParameters('4012');
        $this->addMacParameter(Constants::SND_ID, $this->storeId);
        $this->addMacParameter(Constants::REC_ID);
        $this->addMacParameter(Constants::NONCE, self::generateNonce());
        $this->addMacParameter(Constants::RETURN_URL, $this->returnUrl);
        if($this->datetime && $this->datetime instanceof \DateTime) {
            $this->addMacParameter(Constants::DATETIME, $this->datetime->format(\DateTime::ISO8601));
        } else {
            $this->addMacParameter(Constants::DATETIME, '');
        }
        $this->addMacParameter(Constants::RID, '');
    }

    /*
     * Kaupmehele edastatakse nonssi koopia.
     */
    protected function create3013() {
        $this->addCommonParameters('3013');
        $this->addMacParameter(Constants::USER);
        $this->addMacParameter(Constants::DATETIME);
        $this->addMacParameter(Constants::SND_ID);
        $this->addMacParameter(Constants::REC_ID);
        $this->addMacParameter(Constants::NONCE);
        $this->addMacParameter(Constants::USER_NAME);
        $this->addMacParameter(Constants::USER_ID);
        $this->addMacParameter(Constants::COUNTRY);
        $this->addMacParameter(Constants::OTHER);
        $this->addMacParameter(Constants::TOKEN);
        $this->addMacParameter(Constants::RID);
    }
}
