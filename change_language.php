<?php
session_start();
include_once("settings.php");

$_SESSION["to_lang"] = $_REQUEST["new_language"];

$response = array();
$response["status"]="ok";
$response["to_lang"]=$_SESSION["to_lang"];
echo json_encode($response);
?>