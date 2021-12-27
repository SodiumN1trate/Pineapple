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
    public static function getEmailList()
    {
        $allEmails = array();
        $query = (new Database)->get()->query("SELECT * FROM `emails`");
        while($result = $query->fetch_assoc()){
            $allEmails[] = $result;
        }
        return $allEmails;
    }

    // Emails for response
    public static function getEmails($request)
    {
        $search_bar = isset($request['search_bar']) ? $request['search_bar'] : NULL ;
        $host = isset($request['host']) ? $request['host'] : NULL ;
        $sort = isset($request['sort']) ? $request['sort'] : NULL ;
        $emails = array();
        
        if($search_bar)
        {
            $emails = Email::searchEmail($search_bar, $emails);
        }
        
        if($host)
        {
            $emails = Email::getEmailsSortedByHost($host, $emails);
        }
        
        if($sort)
        {
            $emails = Email::sortEmails($sort, $emails);
        }

        if(!$emails)
        {
            return response(Email::getEmailList());
        }
        else
        {
            return response($emails);
        }
    }

    public static function sortEmails($sort_by, $emails)
    {
        if(empty($emails))
        {
            $emails = Email::getEmailList();
        }
        if ($sort_by == 'name')
        {
            array_multisort(array_column($emails, 'email'), SORT_ASC, $emails);
        }
        elseif ($sort_by == 'date') {
            array_multisort(array_column($emails, 'date'), SORT_DESC, $emails);
        }
        return $emails;
    }
    
    public static function getEmailsSortedByHost($host, $emails)
    {
        $validEmails = array();
        if(!$emails)
        {
            $emails = Email::getEmailList();
        }
        foreach ($emails as $key => $value)
        {
            if(str_contains(strtolower($emails[$key]['host']), strtolower($host)))
            {
                $validEmails[] = $emails[$key];
            }
        }
        return $validEmails;
    }

    public static function getHosts()
    {
        $hosts = array();
        $emails = Email::getEmailList();
        foreach ($emails as $key => $value)
        {
            $host = $emails[$key]['host'];
            if(!in_array($host, $hosts)){
                $hosts[] = $host;
            }
        }
        return response($hosts);
    }

    public static function searchEmail($input, $emails)
    {
        $validEmails = array();
        if(empty($emails))
        {
            $emails = Email::getEmailList();
        }
        foreach ($emails as $key => $value)
        {
            if(str_contains(strtolower($emails[$key]['email']), strtolower($input)))
            {
                $validEmails[] =  $emails[$key];
            }
        }
        return $validEmails;
    }

    public static function deleteEmail($request)
    {
        return response((new Database)->get()->query(sprintf("DELETE FROM `emails` WHERE `id`=%d ;", $request['id'])));
    }
}