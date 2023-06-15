<?php
/*
''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
author : Kennedy
''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
*/	
require_once './vendor/autoload.php';
error_reporting(0);
set_time_limit(0);
class sender {
	private $email = "";
	
	public function Email($email){
		$this->email = $email;
//fungsi send
$randnum = rand(1000,9999);
$message = "$randnum xxxxxxxx "; // isi content smsnya
$from = "+19384449176"; // nomor sender

\Telnyx\Telnyx::setApiKey('KODE API');

$new_message = \Telnyx\Message::Create([
            'from' => $from,
            'to' => "+".$email,
            'text' => $message
]);

if ($new_message) {
    $array1 = $new_message->to;
    $array2 = $new_message->cost;
    $i=0;
    $mid            =  $array1[$i]->status;
    $carrier        =  $array1[$i]->carrier;
    $line_type      =  $array1[$i]->line_type;
    $accid          =  $array1[$i]->phone_number;
    $currencyku     =  $array2->amount;
    $delive         =  $new_message->received_at;
    $enddata        =  "\e[1;32;44m
     - status          : [".$mid."]
     - target          : [".$accid."]
     - Provider        : [".$carrier."]
     - Line Type       : [".$line_type."]
     - Delivered at    : [".$delive."]
     - Cost Send       : $".$currencyku."\e[0m";
    echo "\e[1;34;40m[".date("H:i:s")."] content created!      : {$message}\e[0m\n";
    echo "\e[1;34;40m[".date("H:i:s")."] Sending...\e[0m\n";
    sleep(2);
    echo $enddata. "\n\n";
    //echo $getkonten. "\n";
    sleep(6);
    }else{
    echo "message failure to send!";
    }
$ch = curl_init();
 
curl_setopt($ch, CURLOPT_URL, "https://api.telnyx.com/v2/balance");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER,     array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer KODE API"
));

$resultz         = curl_exec ($ch);
$arrayz          = json_decode($resultz);
$array3          = $arrayz->data;
$balancelast     = $array3->available_credit;
$balancek        = "\e[1;33;40mAvailable BALANCE : USD ".$balancelast."\e[0m\n";
echo "\e[1;32;40mSMS SEND SUCCESS!\e[0m\n";
echo $balancek;
    }
}
	$Logo = "\e[1;33;40m  

__ _  ____  ____    __   __      ___   __  ____  __     __  __ _ 
_  ________ _   _ _   _ ______ _______     __
| |/ /  ____| \ | | \ | |  ____|  __ \ \   / /
| ' /| |__  |  \| |  \| | |__  | |  | \ \_/ / 
|  < |  __| | . ` | . ` |  __| | |  | |\   /  
| . \| |____| |\  | |\  | |____| |__| | | |   
|_|\_\______|_| \_|_| \_|______|_____/  |_|  
                                                                                         
                        // SMS SENDER \\
                -----------------------------------
\e[0m";
$xend = new sender();
if(isset($argv[1])){
    $get	= file_get_contents($argv[1]) or die("\n\e[1;31;40m[Warning] Phonenumber list not founded !!!\e[0m\n");
    $listemail	= explode("\r\n",$get);
	echo "\n\e[1;33;40m[".date("H:i:s")."] Preparing sending sms to ".count($listemail)." Phonenumber.\e[0m\n";
    echo "\n\e[1;33;40m[".date("H:i:s")."] Creating Content Please wait ... \e[0m\n";
    sleep(2);
    foreach($listemail as $email){
	echo "[".date("H:i:s")."] Try Sending sms to : {$email}\n";
		$f1 = fopen("latest-email.txt","w");
		fwrite($f1,$email."\r\n");
		fclose($f1);
	$xend->Email($email);
	}
	echo "DONE - SUCCESSFULLY SEND SMS TO ".count($listemail)." PHONE NUMBER";
}	else {
	echo $Logo."\n";
	echo "[=] command to use   : php $argv[0] listphone.txt\n";
}