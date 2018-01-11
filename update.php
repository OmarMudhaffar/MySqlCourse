<?php

$db = mysqli_connect("localhost","user","password","dataname");

ob_start();
$token = "TOKEN";
define("API_KEY", $token);
function bot($method,$datas=[]){
$url = "https://api.telegram.org/bot".API_KEY."/".$method;
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
$res = curl_exec($ch);
if(curl_error($ch)){
var_dump(curl_error($ch));
}else{
return json_decode($res);
}
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$text = $message->text;
$ex = explode(" ", $text);

$update = mysqli_query($db, "UPDATE users SET msg = '".$ex[1]."' WHERE msg = '".$ex[0]."' ");

if($text){
if($update){
bot('sendMEssage',[
'chat_id'=>$chat_id,
'text'=>"done"
]);
}
}

