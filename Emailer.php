<?php 

class Emailer {
    private $SenderAddress;
    private $SendToAddress;
    private $Subject;
    private $Message;
    private $errorMsg; //used for sendEmail() function


    function __construct($Sender, $SendTo, $Subj, $Mess){
        $this->SenderAddress = $Sender;
        $this->SendToAddress = $SendTo;
        $this->Subject = $Subj;
        $this->Message = $Mess;
    }

    function setSenderAddress($input){
        $this->SenderAddress = $input;
    }

    function setSendToAddress($input){
        $this->SendToAddress = $input;
    }

    function setSubject($input){
        $this->Subject = $input;
    }

    function setMessage($input){
        $this->Message = $input;
    }

    function getSenderAddress(){
        return $this->SenderAddress;
    }

    function getSendToAddress(){
        return $this->SendToAddress;
    }

    function getSubject(){
        return $this->Subject;
    }

    function getMessage(){
        return $this->Message;
    }

    function sendEmail() {
        
        //check for proper format
        $errorMessage = "";
        $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

        if(!preg_match($email_exp, $this->SenderAddress)) {
            $errorMessage .= 'The Senders Email Address does not appear to be valid.<br />';
        }
        
        if(!preg_match($email_exp,$this->SendToAddress)) {
            $errorMessage .= 'The Send To Email Address does not appear to be valid.<br />';
        }

        if(strlen($this->Message) < 2) {
            $errorMessage .= 'The message you entered was too short.<br />';
        }


        if($errorMessage == "") { //No errors in the message
            $headers = 'To: '.$this->SendToAddress."\r\n".
                'From: '.$this->SenderAddress."\r\n".
                'Reply-To: '.$this->SenderAddress."\r\n" .
                'X-Mailer: PHP/' . phpversion();
            //Commented out because I don't want mail actually sent from this page.
            //@mail($this->SendToAddress, $this->Subject, $this->Message, $headers);
            $msg = "Your message was sent. Message: <br>" . "$headers <br>" . "Sent to - $this->SendToAddress <br> Subject - $this->Subject <br>" . "Message - $this->Message";
            return $msg;
        } else {
            return $errorMessage;
        }
    }
}

?>