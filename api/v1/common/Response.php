<?php
class Response {
    public $Success;
    public $Data;
    public $ItemsCount;
    public $MessageCode;
    public $MessageText;

    function SuccessMessage($data)
    { 
        $this->Success = true;
        $this->MessageCode = 0;
        $this->MessageText = "Islem Basariyla Tamamlandi";
        $this->Data = $data;
        $this->ItemsCount = sizeof($data);
    }
    function SuccessMessageNullData()
    { 
        $this->Success = true;
        $this->MessageCode = 0;
        $this->MessageText = "Islem Basariyla Tamamlandi";
        $this->Data = null;
        $this->ItemsCount = 0;
    }
    function SuccessMessageWithCode($code, $message, $data)
    { 
        $this->Success = true;
        $this->MessageCode = $code;
        $this->MessageText = $message;
        $this->Data = $data;
        $this->ItemsCount = sizeof($data);
    }
    function SuccessMessagePager($data, $itemCount)
    { 
        $this->Success = true;
        $this->MessageCode = 0;
        $this->MessageText = "Islem Basariyla Tamamlandi";
        $this->Data = $data;
        $this->ItemsCount = $itemCount;
    }

    function ErrorMessage($messageCode, $messageText)
    { 
        $this->Success = false;
        $this->MessageCode = $messageCode;
        $this->MessageText = $messageText;
        $this->Data = null;
        $this->ItemsCount = 0;
    } 
}

function Ok($response)
{
    echo json_encode($response);
}
?>