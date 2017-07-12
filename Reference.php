<?php

class Reference
{
    private $base_convert;
    private $id;
    private $type;
    private $types;

    public function __construct($base_convert) {

        $this->base_convert = $base_convert;

        $this->types = [
            'CRM' => 10,
            'APP' => 20,
        ];

    }

    public function encode($type, $decimal)
    {

        $decimal = $this->types[$type] . str_pad($decimal, '0', 7);

        return $this->base_convert->encode($decimal);

    }

    public function decode($string)
    {

        $decimal    = $this->base_convert->decode($string);

        $type       = substr($decimal, 0, 2);
        $id         = substr($decimal, 2, mb_strlen($decimal));

        $types      = array_flip($this->types);

        $this->id   = $id;
        $this->type = $types[$type];

        return $this;

    }

    public function id()
    {

        return $this->id;

    }

    public function type()
    {

        return $this->type;

    }

}