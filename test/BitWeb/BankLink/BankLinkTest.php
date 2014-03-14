<?php

namespace BitWeb\BankLink;

class BankLinkTest extends \PHPUnit_Framework_TestCase
{
    function testGetBankNameByBankAccount()
    {
        $this->assertEquals('Swedbank', BankLink::getBankNameByAccountNumber('22'));
        $this->assertEquals('Swedbank', BankLink::getBankNameByAccountNumber('11'));
        $this->assertEquals('SEB', BankLink::getBankNameByAccountNumber('10'));
        $this->assertEquals('Krediidipank', BankLink::getBankNameByAccountNumber('42'));
        $this->assertEquals('Eesti Pank', BankLink::getBankNameByAccountNumber('16'));
        $this->assertEquals('Bank DnB NORD', BankLink::getBankNameByAccountNumber('96'));
        $this->assertEquals('Nordea', BankLink::getBankNameByAccountNumber('17'));
        $this->assertEquals('Citadele Pank', BankLink::getBankNameByAccountNumber('12'));
        $this->assertEquals('Versobank', BankLink::getBankNameByAccountNumber('55'));
        $this->assertEquals('Danske', BankLink::getBankNameByAccountNumber('33'));
        $this->assertEquals('Svenska Handelsbanken', BankLink::getBankNameByAccountNumber('83'));
        $this->assertEquals('Tallinna Äripank', BankLink::getBankNameByAccountNumber('93'));
        $this->assertEquals('Pohjola Bank plc Eesti filiaal', BankLink::getBankNameByAccountNumber('51'));
        $this->assertEquals('LHV Pank', BankLink::getBankNameByAccountNumber('77'));
        $this->assertEquals('BIGBANK AS', BankLink::getBankNameByAccountNumber('75'));
        $this->assertEquals('Unknown', BankLink::getBankNameByAccountNumber(null));
    }

    public function testGetBankNameByIban()
    {
        $this->assertEquals('Swedbank', BankLink::getBankNameByIban('EE0022'));
        $this->assertEquals('Eesti Pank', BankLink::getBankNameByIban('EE0016'));
        $this->assertEquals('SEB', BankLink::getBankNameByIban('EE0010'));
        $this->assertEquals('Danske', BankLink::getBankNameByIban('EE0033'));
        $this->assertEquals('Nordea', BankLink::getBankNameByIban('EE0017'));
        $this->assertEquals('Citadele Pank', BankLink::getBankNameByIban('EE0012'));
        $this->assertEquals('Versobank', BankLink::getBankNameByIban('EE0055'));
        $this->assertEquals('Krediidipank', BankLink::getBankNameByIban('EE0042'));
        $this->assertEquals('Svenska Handelsbanken', BankLink::getBankNameByIban('EE0083'));
        $this->assertEquals('Pohjola Bank plc Eesti filiaal', BankLink::getBankNameByIban('EE0051'));
        $this->assertEquals('LHV Pank', BankLink::getBankNameByIban('EE0077'));
        $this->assertEquals('BIGBANK', BankLink::getBankNameByIban('EE0075'));
        $this->assertEquals('DNB Pank', BankLink::getBankNameByIban('EE0096'));
        $this->assertEquals('Tallinna Äripank', BankLink::getBankNameByIban('EE0000'));
        $this->assertEquals('Unknown', BankLink::getBankNameByIban(null));
        $this->assertEquals('Unknown', BankLink::getBankNameByIban(''));
        $this->assertEquals('Unknown', BankLink::getBankNameByIban('EE0099'));
    }

    public function testGetReferenceNumber()
    {
        $this->assertEquals('1234561', BankLink::generateReferenceNumber('123456'));
        $this->assertEquals('6543215', BankLink::generateReferenceNumber('654321'));
    }
} 