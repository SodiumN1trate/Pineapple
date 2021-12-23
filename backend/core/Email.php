<?php

class Email
{
    private $email;
    private $host;
    private $checkboxChecked;

    public function __construct($email, $checkbox)
    {
        $this->email = $email;
        $this->checkboxChecked = $checkbox;
        $this->host = $this->getHost();
    }

    public static function add_email()
    {   
        $obj = EmailValidation::getEmailValidStatus(new Email($_POST['email'], $_POST['checkbox']));
        echo response($obj->isEmailValid());
    }

    private function getHost()
    {
        preg_match('/(?<=@)[^.]+(?=\.)/', $this->email, $host);
        return $host;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCheckbox()
    {
        return $this->checkboxChecked;
    }
}


        // $validationResult = EmailValidation();
        // if($validationResult == "true"){
        //     $output = array('email'=>$this->email, 'checkbox'=>$this->checkBoxChecked);
        //     echo json_encode($output);
        // }
        // else
        // {
        //     $err = array('error'=> $validationResult);
        //     echo json_encode($err);
        // }