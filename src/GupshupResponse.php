<?php

namespace VivekDhumal\GupshupSMS;

class GupshupResponse
{
    public $status;
    public $message;
    public $id;
    public $details;
    public $phone;

    public function __construct($status, $message = null, $id = null, $details = null, $phone = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->id = $id;
        $this->details = $details;
        $this->phone = $phone;
    }
}