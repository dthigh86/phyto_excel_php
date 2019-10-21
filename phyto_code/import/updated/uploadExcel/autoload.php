<?php


include 'includes/PHPExcel/IOFactory.php';
require_once "includes/PHPExcel.php";
require_once "includes/db.php";

global $config;
global $database;

function setupVars()
{
	$config = parse_ini_file("config/config.ini");
}

setupVars();
