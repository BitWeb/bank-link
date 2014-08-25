<?php

namespace BitWeb\BankLink;

use BitWeb\BankLink\Swedbank\SwedBank;
/**
 * Main BankLink class that represents actions for bank links
 *
 *<code>
 *try {
 *
 *    $link = new SEBLink('/home/tobre/www/pangalink/horizon/key_seb.pem', '/home/tobre/www/pangalink/horizon/eypcert.pem');
 *    //$link = new SwedBankLink('/home/tobre/www/pangalink/horizon/privkey.pem', '/home/tobre/www/pangalink/horizon/IpizzaHPavalikvoti.pem');
 *    if ($link->isRequest()) {
 *        if (isset($_GET['doBank'])) {
 *            $link->setAccountNumber('10000004089017');
 *            $link->setAmount($_GET['amount']);
 *            $link->setMessage('BitWeb test');
 *            $link->setReferenceNumber('643519');
 *            if ($link->getBankId() == 'EYP') {
 *                $link->setStoreId('horizontr');
 *            } else {
 *                $link->setStoreId('HORIZON');
 *            }
 *            $link->setReturnUrl('http://localhost/pangalink/sources/BankLink/?r=1');
 *            $link->create(1002);
 *            echo $link->getForm();
 *        } else {
 *            ?>
 *            <a href="?doBank&amount=0.01">Tee makse</a>
 *            <?php
 *        }
 *
 *    } else {
 *        if ($link->isAccepted($link->getResponse())) {
 *            echo 'accepted';
 *            //echo $link->getValue(SEBLinkConstants::SND_NAME);
 *            print_r($link);
 *
 *        } else {
 *            echo 'ei aksepteeritud';
 *        }
 *    }
 *} catch(Exception $e) {
 *    print_r($link);
 *    print_r($e);
 *}
 *</code>
 *
 * @author Tõnis Tobre <tobre@bitweb.ee>
 * @copyright Copyright (C) 2009. All rights reserved. Tõnis Tobre
 *
 * Change Log:
 * Date            User        Comment
 * ---------------------------------
 * Mar 24, 2009    tobre    Initial version
 */
abstract class BankLink
{

    /**
     * Bank url
     * @var string
     */
    protected $url;

    /**
     * MAC version. Default is 008
     * @var string
     */
    protected $version = '008';

    /**
     * Currency
     * @var string
     */
    protected $currency = 'EUR';

    /**
     * Default communication language
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
     * Client reference number
     * @var Client account number
     */
    protected $referenceNumber;

    /**
     * Payment message
     * @var $message
     */
    protected $message;

    /**
     * Payment amount
     * @var string
     */
    protected $amount;

    /**
     * URL where to come back from bank
     * @var string
     */
    protected $returnUrl;

    /**
     * Payment stamp
     * @var integer
     */
    protected $stamp = 1;

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
    private $certification;

    /**
     * Passphrase for client private key
     * @var string
     */
    private $passPhrase;

    /**
     * Method parameters array
     * @var array
     */
    protected $parameters = array();

    /**
     * Field names and ordering for generating MAC
     * @var array
     */
    private $orders = array();

    /**
     *  Holds info for methods that represents bank not accepting payment
     * @var boolean
     */
    private $isFailedDealing = false;


    /**
     * Constructor for seting private and public keys
     * @param string $privateKey Client private key
     * @param string $certification Bank public key
     */
    public function __construct($privateKey = null, $certification = null)
    {
        $this->privateKey = $privateKey;
        $this->certification = $certification;
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
     * @param string $certification Bank public key
     * @return BankLinkObject
     */
    public function setCertification($certification)
    {
        $this->certification = $certification;
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
     * @return Bank URL
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
     * Creates request and response methods for communicating bank
     * @param integer $service Service that is used for current action
     * @return true if dealing has been cancelled false otherwise
     * @throws Exception when there are no such method
     */
    public function create($service)
    {
        $method = 'create' . $service;
        if (!method_exists($this, $method)) {
            throw new Exception('No such method "' . $method . '"');
        }

        $this->$method();
        if ($this->isResponse()) {
            $this->verifyMac();
        } else {
            $this->calculateMac();
        }

        return $this->isFailedDealing;
    }

    /**
     * Gets right response method and load right values from request
     * @return create() return value
     */
    public function getResponse()
    {
        $this->loadValues();
        return $this->create($this->parameters[Constants::SERVICE]->getValue());
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

    /**
     * Checks if query is request
     * @return true if query is request, false otherwise
     */
    final public function isRequest()
    {
        return !$this->isResponse();
    }

    /**
     * Checks if query is response
     * @return true if query is response, false otherwise
     */
    public function isResponse()
    {
        return isset($_REQUEST[Constants::SERVICE]);
    }

    final public function getForm()
    {
        $formHTML = '<html><body>';
        $formHTML .= '<form id="bankForm" method="POST" action="' . $this->url . '">' . PHP_EOL;
        $formHTML .= $this->drawFields();
        $formHTML .= '</form>';
        $formHTML .= '<script type="text/javascript">document.getElementById("bankForm").submit();</script></body></html>';
        return $formHTML;
    }

    /**
     * Sets bank specific parameters
     */
    protected abstract function setSpecificParameters();

    /**
     * Adds MAC parameter that is counted when MAC is beeing generated
     * @param string $field Parameter field
     * @param string $length Parameter length
     * @param $defaultValue Parameter default value
     * @see BankLink#addParameter()
     */
    final protected function addMacParameter($field, $length, $defaultValue = null)
    {
        $this->orders[] = $field;
        $this->addParameter($field, $length, $defaultValue);
    }

    /**
     * Adds parameter to service method
     * @param string $field Parameter field
     * @param string $length Parameter length
     * @param string $defaultValue Parameter default value
     */
    final protected function addParameter($field, $length, $defaultValue = null)
    {
        if (isset($this->parameters[$field]) && $this->parameters[$field] instanceof Parameter) {
            $this->parameters[$field]->setLength($length);
        } else {
            $this->parameters[$field] = new Parameter($field, $defaultValue, $length);
        }
    }

    /**
     * Adds common parameters that is common for all service methods
     * @param integer $service Method number
     * @param boolean $isFailedDealing Sets true if this method is failing method
     */
    protected function addCommonParameters($service, $isFailedDealing = false)
    {
        $this->setServiceMetadata($isFailedDealing);
        $this->addMacParameter(Constants::SERVICE, Constants::SERVICE_LENGTH, $service);
        $this->addMacParameter(Constants::VERSION, Constants::VERSION_LENGTH, $this->version);
        $this->setSpecificParameters();
    }

    /**
     * Sets service metadata.
     * @param boolean $isFailedDealing
     */
    final protected function setServiceMetadata($isFailedDealing = false)
    {
        $this->orders = array();
        $this->isFailedDealing = $isFailedDealing;
    }

    /**
     * Generates uniq nonce value
     * @return Unique nonce
     */
    protected function generateNonce()
    {
        return sha1(uniqid(rand(), true));
    }

    /**
     * Calculates MAC value over client private key and sets it
     * @throws Exception when signing fails
     * @return MAC signature
     */
    protected function calculateMac()
    {
        $privateKeyContents = file_get_contents($this->privateKey);
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
    protected function verifyMac()
    {
        $certificate = file_get_contents($this->certification);

        $publicKeyId = openssl_get_publickey($certificate);
        $isVerified = openssl_verify($this->getMacSource(), base64_decode($this->parameters[Constants::MAC]->getFormattedValue()), $publicKeyId);
        openssl_free_key($publicKeyId);
        if (!$isVerified) {
            throw new Exception('Verifying failed');
        }
    }

    /**
     * Calculates MAC source by mandatory values
     * @return MAC source
     */
    private function getMacSource()
    {
        $data = '';
        foreach ($this->orders as $order) {
            $value = $this->parameters[$order]->getFormattedValue();
            if (null === $value) {
                throw new Exception('"' . $order . '" has to be setted');
            }
            $length = $this instanceof SwedBank ? mb_strlen($value, 'UTF-8') : strlen($value);
            $data .= str_pad($length, 3, '0', STR_PAD_LEFT) . $value;
        }
        return $data;
    }

    /**
     * Load values from request. And sets into parameters
     * @param array $data Where to load values. Default is $_REQUEST
     * @see BankLink#setParameter()
     */
    protected function loadValues(array $data = null)
    {
        if (null === $data) {
            $data = $_REQUEST;
        }
        foreach ($data as $field => $value) {
            $this->setParameter($field, $value);
        }
    }

    /**
     * Draws neccessary form hidden fields
     * @return string Fields HTML code
     */
    private function drawFields()
    {
        $fieldsHTML = '';
        foreach ($this->getFields() as $field => $value) {
            $fieldsHTML .= '<input type="hidden" name="' . $field . '" value="' . $value . '" />' . PHP_EOL;
        }
        return $fieldsHTML;
    }

    protected function getMacParameters()
    {
        return $this->orders;
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
    public static function getBankNameByAccountNumber($accountNumber)
    {
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

    public static function getBankNameByIban($iban)
    {
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
}
