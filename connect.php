<?php

$db = mysqli_connect("localhost","user","password","dataname");

if($db){
    echo "done";
}
else{
    echo "not work";
}
