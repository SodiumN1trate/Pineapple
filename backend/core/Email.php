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

    public static function addEmail()
    {   
        $emailObj = new Email($_POST['email'], $_POST['checkbox']);
        $validation = EmailValidation::getEmailValidStatus($emailObj);
        if(!isset($validation['error']))
        {
            $emailObj->saveEmail();
        }
        return response($validation);
    }

    private function getHost()
    {
        preg_match('/(?<=@)[^.]+(?=\.)/', $this->email, $host);
        return $host[0];
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCheckbox()
    {
        return $this->checkboxChecked;
    }

    private function saveEmail()
    {
        return (new Database)->get()->query(sprintf("INSERT INTO `emails` (`email`, `host`, `date`) VALUES ('%s', '%s', '%s');", $this->email, $this->host, date("Y-m-d H:i:s")));
    }

    // Emails from db
    public static function getEmailList($sort_by, $order)
    {
        $allEmails = array();
        $query = (new Database)->get()->query(sprintf("SELECT * FROM `emails` ORDER BY `%s` %s;", $sort_by, $order));
        while($result = $query->fetch_assoc()){
            $allEmails[] = $result;
        }
        return $allEmails;
    }

    // Emails for response
    public static function getEmails()
    {
        return response(Email::getEmailList('date', 'DESC'));
    }

    // Emails for response
    public static function getEmailsSortedByName()
    {
        return response(Email::getEmailList('email', 'ASC'));
    }
    
    public static function getEmailsSortedByHost()
    {
        $emailWithHost = array();
        $emails = Email::getEmailList('date', 'DESC');
        foreach($emails as $key => $value)
        {
            if($emails[$key]['host'] == $_POST['host'])
            {
                $emailWithHost[] = $emails[$key];
            }
        }
        return response($emailWithHost);
    }

    public static function getHosts()
    {
        $hosts = array();
        $emails = Email::getEmailList('date', 'DESC');
        foreach ($emails as $key => $value)
        {
            $host = $emails[$key]['host'];
            if(!in_array($host, $hosts)){
                $hosts[] = $host;
            }
        }
        return response($hosts);
    }

}