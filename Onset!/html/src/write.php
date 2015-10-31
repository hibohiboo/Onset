<?php
session_start();
require 'func.php';


$name = $_POST['name'] != NULL ? trim(htmlspecialchars($_POST['name'] , ENT_QUOTES)) : NULL;
$text = $_POST['text'] != NULL ? trim(htmlspecialchars($_POST['text'] , ENT_QUOTES)) : NULL;
$room = $_POST['room'];

if($text === NULL || $name === NULL){	//テキストが空白ならエラーを返す
	die();
}

//var_dump($_POST);
//var_dump($name);
//var_dump($text);

$name = nl2br($name);
$text = nl2br($text);

$dice = dice($text);
if($dice === FALSE){
	$dice_roll = "";
}else{
	$dice_roll = "<b>".$dice["text"]."\n→".$dice["num"]."</b>";
}


//var_dump($name);
//var_dump($text);

$line = date("Y/m/d G:i:s")."&#009;".$name."<br>".$text."<br>".$dice_roll."<hr><br>\n";

//var_dump($line);


$line = $line.file_get_contents("../log/xxlogxx.txt");
file_put_contents("../log/xxlogxx.txt", $line);

?>