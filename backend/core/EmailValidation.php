<?php

class EmailValidation
{
    private $email;
    private $checkbox;
    public function __construct($email, $checkbox)
    {
        $this->email = $email;
        $this->checkbox = $checkbox;
        $this->validEmail();
    }

    public static function getEmailValidStatus(Email $obj)
    {
        return (new EmailValidation($obj->getEmail(), $obj->getCheckbox()))->validEmail();
    }

    public function isEmailProvided()
    {
       return $this->email != '';
    }

    private function isEmail()
    {
        return preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $this->email);
    }

    private function isCheckboxChecked()
    {
        return $this->checkbox == "true";
    }

    private function isEmailContainsIllegalDomain()
    {
        return preg_match('/\.co$/', $this->email);
    }

    private function validEmail()
    {
        if(!$this->isEmailProvided())
        {
            return array('error'=>'Email address is required');
        }
        elseif(!$this->isEmail())
        {
            return array('error'=>'Please provide a valid e-mail address');
        }
        elseif(!$this->isCheckboxChecked())
        {
            return array('error'=>'You must accept the terms and conditions');
        }
        elseif($this->isEmailContainsIllegalDomain())
        {
            return array('error'=>'We are not accepting subscriptions from Colombia emails');
        }
        return array('email'=>$this->email, 'checkbox'=>$this->checkbox);
    }
}