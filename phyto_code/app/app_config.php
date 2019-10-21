<?php
/**
 * Phyto DB
 
 * - Phyto Global Configuration
 
*/

// Database conn
$DB_host = "localhost";
$DB_name = ""; //DATABASE NAME

$DB_user = ""; //DATABASE USER
$DB_pass = ""; //DATABASE PASSWORD

global $app_DB;
$app_DB = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
if ($app_DB->connect_errno) {
    echo "Failed to connect to MySQL: (" . $app_DB->connect_errno . ") " . $app_DB->connect_error;
}



/** Master DB User (this user can edit members and import data) **/
$masterDBUser = "pdbadmin";
$masterDBPass = "admin";
/** READ ONLY DB user (user can only read & search items) **/
$roDBUser = "pdbguest";
$roDBPass = "guest";


/*********************/
/*** APP Functions ***/
/*********************/

/** Membership Management **/
function verify_member($usr, $pass){
    $isvalid = false;
    
    // Open file
    $file = fopen("app/app_member.txt", "r") or exit("Unable to open file!");
    while(!feof($file)){
        $newline = fgets($file);
        $membres = explode(";",$newline);
        $membname = (string)$membres[0];
        $membpass = (string)$membres[1];
        if( trim($membname) === (string)trim($usr) && trim($membpass) === (string)trim($pass) ) { $isvalid = true; }
   
    }
    fclose($file);

    return $isvalid;
    
}

?>