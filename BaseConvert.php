<?php
// 4,294,967,295

class BaseConvert
{

    private $charset;
    private $base;
    public  $errors;

    public function __construct()
    {

        $this->charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $this->charset = '0123456789ABCDEGHJKLMNPQRTVWXYZ';

        // I, O, U, S, F
        $this->base    = mb_strlen($this->charset);

    }

    public function setCharSet($charset)
    {

        $this->charset = $charset;
        $this->base    = mb_strlen($this->charset);

    }

    public function setBase($base)
    {

        $this->base = $base;

        if($this->base > mb_strlen($this->charset)) {
            die('Base exceeds charset.');
        }

    }

    private function validateBase()
    {

        // Make sure that the base number is valid.
        if ($this->base < 2 | $this->base  > 36 | $this->base  == 10) {
            $this->errors[] = 'BASE must be in the range 2-9 or 11-36.';
            return false;
        }

        return true;

    }


    public function encode($decimal)
    {

        if(!$this->validateBase()) {
            return false;
        }

        // Checking that $decimal is a positive integer between 1 and 16 digits long.
        if (!preg_match('(^[0-9]{1,16}$)', trim($decimal))) {
            $this->errors[] = 'Decimal must be a positive integer.';
            return false;
        };

        $string  = '';
        // Set up the list of possible output characters, then chop off any characters beyond the limit specified by $this->base.
        $charset = substr($this->charset, 0, $this->base);
        $decimal = trim((int)$decimal);

        do {
            $remainder = ($decimal % $this->base);
            // Extract the character that corresponds to this remainder and add it to the front of the output string.
            $char      = substr($charset, $remainder, 1);
            $string    = "$char$string";
            // Reduce the decimal value by the number we have just processed. This is done by subtracting $remainder then dividing by $this->base.
            $decimal   = ($decimal - $remainder) / $this->base;
        } while ($decimal > 0);

        return $string;

    }

    public function decode($string)
    {

        if(!$this->validateBase()) {
            return false;
        }

        // Check string is not empty.
        if(empty($string)) {
            $this->errors[] = 'Input string is empty.';
            return false;
        }

        $decimal = 0;
        // Set up the list of possible output characters, then chop off any characters beyond the limit specified by $this->base.
        $charset = substr($this->charset, 0, $this->base);
        $string  = trim($string);

        do {

            // Extract the first character from the input string, then remove it from the string.
            $char    = substr($string, 0, 1);
            $string  = substr($string, 1);
            // Obtain the position of $char in $charset.
            $pos     = strpos($charset, $char);

            if ($pos === false) {
                $this->errors[] = "Illegal character ($char) in INPUT string";
                return false;
            }

            // Increment the decimal value by the value of the character we have just extracted from the input string.
            $decimal = ($decimal * $this->base) + $pos;

        } while($string <> null);

        return $decimal;

    }

}
