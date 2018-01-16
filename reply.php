<?php

$db = mysqli_connect("localhost","user","password","dataname");
mysqli_query("SET NAMES utf8");
mysqli_query("SET CHARACTER SET utf8");


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

$ex = explode(":",$text);

if(isset($ex[1])){

$txt = $ex[0];
$reply = $ex[1];

$exu = mysqli_query($db, "INSERT INTO txtreply (chatid,txt,reply) VALUES ('$chat_id','$txt','$reply')");

if($exu){
 bot('sendMessage',[
     'chat_id'=>$chat_id,
     'text'=>"done"
    ]);
}

}


if($text){
$get = mysqli_query($db, "SELECT * FROM txtreply WHERE chatid = '".$chat_id."' AND txt = '".$text."' " );
$fe = mysqli_fetch_assoc($get);

if($text == $fe['txt']){
 bot('sendMessage',[
     'chat_id'=>$chat_id,
     'text'=>$fe['reply']
    ]);
}

}
