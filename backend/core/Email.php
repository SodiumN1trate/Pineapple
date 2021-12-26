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
        return (new Database)->get()->query(sprintf("INSERT INTO `emails` (`email`, `host`, `date`) VALUES ('%s', '%s', '%s');", $this->email, ucfirst($this->host), date("Y-m-d H:i:s")));
    }

    // Emails from db
    public static function getEmailList($sort_by, $order, $like = '@')
    {
        $allEmails = array();
        $query = (new Database)->get()->query(sprintf("SELECT * FROM `emails` WHERE `email` LIKE '%s' ORDER BY `%s` %s;", '%' . $like . '%', $sort_by, $order));
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

    public static function getEmailsSortedByName()
    {
        sort($_POST['emails']);
        return response($_POST['emails']);
    }

    public static function getEmailsSortedByDate()
    {
        array_multisort(array_column($_POST['emails'], 'date'), SORT_DESC, $_POST['emails']);
        return response($_POST['emails']);
    }
    
    public static function getEmailsSortedByHost()
    {
        $validEmails = array();
        foreach ($_POST['emails'] as $key => $value)
        {
            if(str_contains(strtolower($_POST['emails'][$key]['host']), strtolower($_POST['host'])))
            {
                $validEmails[] = $_POST['emails'][$key];
            }
        }
        return response($validEmails);
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

    public static function searchEmail()
    {
        $validEmails = array();
        foreach ($_POST['emails'] as $key => $value)
        {
            if(str_contains(strtolower($_POST['emails'][$key]['email']), strtolower($_POST['input'])))
            {
                $validEmails[] = $_POST['emails'][$key];
            }
        }
        return response($validEmails);
    }

    public static function deleteEmail()
    {
        return response((new Database)->get()->query(sprintf("DELETE FROM `emails` WHERE `id`=%d ;", $_POST['id'])));
    }
}