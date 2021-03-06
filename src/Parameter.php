<?php

namespace BitWeb\BankLink;

final class Parameter
{

    private $field;
    private $value;
    private $length;

    public function __construct($field = null, $value = null, $length = null)
    {
        $this->field = $field;
        $this->value = $value;
        $this->length = $length;
    }

    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getFormattedValue()
    {
        return mb_substr($this->value, 0, $this->length);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function __toString()
    {
        return get_class() . '@[field="' . $this->field . '", value="' . $this->value . '", length="' . $this->length . '"]';
    }
}
