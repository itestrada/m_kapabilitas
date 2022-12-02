<?php
session_start();
$s_ID = "";
$s_NAME = "";
$s_LVL = "";
$s_GRP = "";
$s_MENU = array();
$s_MAC = "";
$s_HOME = "home";
$s_LOC = "";

if(isset($_SESSION['s_ID'])){$s_ID = $_SESSION['s_ID'];}
if(isset($_SESSION['s_NAME'])){$s_NAME = $_SESSION['s_NAME'];}
if(isset($_SESSION['s_LVL'])){$s_LVL = $_SESSION['s_LVL'];}
if(isset($_SESSION['s_GRP'])){$s_GRP = $_SESSION['s_GRP'];}
if(isset($_SESSION['s_MENU'])){$s_MENU = $_SESSION['s_MENU'];}
if(isset($_SESSION['s_MAC'])){$s_MAC = $_SESSION['s_MAC'];}
if(isset($_SESSION['s_LOC'])){$s_LOC = $_SESSION['s_LOC'];}

if($s_LVL==9){
	$s_HOME="homexx";
}

if($s_ID==""){
header("Location: index.php?m=Session closed.");
}//end if
