<?php

namespace Vivekdhumal\GupshupSMS;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class GupshupMessage
{
    protected $message;
    protected $to;
    protected $userid;
    protected $password;
    protected $mask;
    protected $entityId;
    protected $templateId;
    protected $sslVerify = true;

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

    public function setSSLVerify($verify)
    {
        $this->sslVerify = $verify;

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
            return new GupshupResponse('error', 'SMS not correct.');
        }
        try {
            $client = new Client([
                'base_uri' => 'https://enterprise.smsgupshup.com',
                'verify' => $this->sslVerify,
            ]);
            
            $response = $client->get('/GatewayAPI/rest', [
                'query' => [
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
                ]
            ]);

            // var_dump($response->getBody()->getContents());
            
            if($response->getStatusCode() >= 200) {
                // Get the response body and decode JSON
                $data = json_decode($response->getBody()->getContents(), true);

                if($data && isset($data['response'])) {
                    return new GupshupResponse($data['response']['status'], null, $data['response']['id'], $data['response']['details'], $data['response']['phone']);
                } else {
                    $arr = array_map('trim', explode('|', $response->getBody()->getContents()));

                    if(isset($arr[2])) {
                        return new GupshupResponse('error', $arr[2]);
                    }
                }
                return new GupshupResponse('error', 'No response from api');
            } else {
                return new GupshupResponse('error', 'SMS is not sent, status code : '.$response->getStatusCode());
            }
        } catch(ConnectException $ex) {
            return new GupshupResponse('error', 'SMS is not sent, error : '.$ex->getMessage());
        }
    }
}