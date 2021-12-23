<?php

class EmailValidation
{
    private $isValid = false;
    private $email;
    private $checkbox;
    private $errorsCount = 0;
    public function __construct($email, $checkbox)
    {
        $this->email = $email;
        $this->checkbox = $checkbox;
        $this->validEmail();
    }

    public static function getEmailValidStatus(Email $obj)
    {
        return response((new EmailValidation($obj->getEmail(), $obj->getCheckbox()))->isEmailValid());
    }

    public function isEmailProvided()
    {
       if($this->email == '') $this->errorsCount += 1;
    }

    public function isEmail()
    {
        if(!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $this->email)) $this->errorsCount += 1;
    }

    public function isCheckboxChecked()
    {
        if($this->checkbox == "false") $this->errorsCount += 1;
    }

    public function isEmailContainsIllegalDomain()
    {
        if(preg_match('/\.co$/', $this->email)) $this->errorsCount += 1;
    }

    
    // TO:DO
    // private function validEmail()
    // {
    //     $validations = array('isEmailProvided', 'isEmail', 'isCheckboxChecked', 'isEmailContainsIllegalDomain');
    //     foreach ($validations as $key => $value)
    //     {
    //         call_user_func($validations);
    //     }
    //     $this->isValid = true;
    // }

    public function isEmailValid()
    {
        return $this->isValid;
    }
}