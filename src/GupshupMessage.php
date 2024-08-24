<?php

namespace Vivekdhumal\GupshupSMS;

use GuzzleHttp\Client;

class GupshupMessage
{
    protected $message;
    protected $to;
    protected $userid;
    protected $password;
    protected $mask;
    protected $entityId;
    protected $templateId;

    public function __construct($userid, $password, $mask, $entityId = null, $templateId = null)
    {
        $this->userid = $userid;
        $this->password = $password;
        $this->mask = $mask;
        $this->entityId = $entityId;
        $this->templateId = $templateId;
    }

    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;   
    }

    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    public function send()
    {
        if (!$this->to || !$this->message) {
            throw new \Exception('SMS not correct.');
        }

        $client = new Client([
            'base_uri' => 'https://enterprise.smsgupshup.com',
        ]);
        
        $response = $client->get('/GatewayAPI/rest', [
            'method' => 'SendMessage',
            'send_to' => $this->to,
            'msg' => $this->message,
            'msg_type' => 'TEXT',
            'userid' => $this->userid,
            'auth_scheme' => 'plain',
            'password' => $this->password,
            'v' => '1.1',
            'format' => 'JSON',
            'mask' => $this->mask,
            'principalEntityId' => $this->entityId,
            'dltTemplateId' => $this->templateId,
        ]);

        return $response;
    }
}