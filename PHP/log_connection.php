<?php


$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "furrpection";

if (!$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
    die("failed to connect!");
}
/*

try {
    $con = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die("failed to connect!");
}
*/


function RequestEncryptKey(){
    $key = "BitchesAndJerks";
    return $key;
}

function RequestEncryptMethod(){
    $method = "AES-256-CBC";
    return $method;
}

function RequestEncryptInitialization(){
    $iv= "a1b2c3d4e5f6g7h8";
    return $iv;
}

function SetEncrypt($data){
    
    $e_method = RequestEncryptMethod();
    $e_key = RequestEncryptKey();
    $e_iv = RequestEncryptInitialization();
    
    $encrypted_data= openssl_encrypt($data, $e_method, $e_key,0,$e_iv);
    return $encrypted_data;
}

function RequestDecrypt($data){

    $d_method = RequestEncryptMethod();
    $d_key = RequestEncryptKey();
    $d_iv = RequestEncryptInitialization();
    
    $decrypted= openssl_decrypt($data, $d_method, $d_key,0,$d_iv);
    return $decrypted;
}




function ObfuscateEmail($email){
    if ($email == ""){
        return;
    }
    list($obs_email, $domain) = explode("@",$email);
    $firstChar = substr($obs_email, 0, 1);
    $obfuscatedEmail = $firstChar . str_repeat("*", strlen($obs_email) - 1) . "@$domain";
    return $obfuscatedEmail;
}
function ObfuscateContact($contact){
    if ($contact != ""){
          
        $contact = substr($contact, 0, 3) . str_repeat("*", strlen($contact) - 3);
    }
    return $contact;
}


function ObfuscateCard($cardNumber){
    $formattedCardNumber = implode(' ', str_split($cardNumber, 4));
    $maskedCardNumber = substr($formattedCardNumber, 0, 2) . str_repeat('*', 14);
    $maskedCardNumber = implode(' ', str_split($maskedCardNumber, 4));
    return $maskedCardNumber;
}
?>
