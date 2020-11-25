<?php
include_once("../modelo/Cliente.php");
include_once("../modelo/Administrador.php"); 
session_start(); 
	session_destroy();
	header("Location: ../index.php");
?>