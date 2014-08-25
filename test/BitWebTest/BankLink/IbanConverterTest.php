<?php

namespace BitWebTest\BankLink;

use BitWeb\BankLink\IbanConverter;

class IbanConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testConverting()
    {
        $this->assertEquals('EE023300335751330008', IbanConverter::bban2iban('335751330008'));
        $this->assertEquals('EE063300336426590004', IbanConverter::bban2iban('336426590004'));
        $this->assertEquals('EE174204278606364305', IbanConverter::bban2iban('4278606364305'));
        $this->assertEquals('EE481010010480337014', IbanConverter::bban2iban('10010480337014'));
        $this->assertEquals('EE581700017002947345', IbanConverter::bban2iban('17002947345'));
        $this->assertEquals('EE642200221023890775', IbanConverter::bban2iban('221023890775'));
        $this->assertEquals('EE912200001107481602', IbanConverter::bban2iban('1107481602'));
        $this->assertEquals('EE951010010106474015', IbanConverter::bban2iban('10010106474015'));
        $this->assertEquals('EE962200221024670855', IbanConverter::bban2iban('221024670855'));
        $this->assertFalse(IbanConverter::bban2iban('22102467085'));
    }

    public function testWrongInputReturnsFalse()
    {
        $this->assertFalse(IbanConverter::bban2iban('ananana'));
        $this->assertFalse(IbanConverter::bban2iban('12345'));
        $this->assertFalse(IbanConverter::bban2iban(null));
    }

    public function testIbanReturnsFalse()
    {
        $this->assertFalse(IbanConverter::bban2iban('EE023300335751330008'));
    }
}
