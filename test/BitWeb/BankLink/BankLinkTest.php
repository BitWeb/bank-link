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
    }
} 