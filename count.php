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
$id = $message->from->id;


if($text == "/start"){

$ch = mysqli_query($db, "SELECT * FROM count WHERE id = '".$id."' ");
$check = mysqli_fetch_assoc($ch);

if($id == $check['id']){
bot('sendMEssage',[
'chat_id'=>$chat_id,
'text'=>"welcome again"
]);
}

if($id != $check['id']){

mysqli_query($db, "INSERT INTO count (id) VALUES ('$id')");

bot('sendMEssage',[
'chat_id'=>$chat_id,
'text'=>"welcome"
]);
}

}

if($text == "/count"){

$co = mysqli_query($db, "SELECT * FROM count");
$count = 0;

while($dbcount = mysqli_fetch_assoc($co)){
 $count ++;
}


bot('sendMEssage',[
'chat_id'=>$chat_id,
'text'=>"count : " . $count
]);
}

