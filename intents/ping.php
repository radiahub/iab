<?php require_once ("config.radia.php"); autoload();
// ============================================================================
// Module      : ping.php
// Version     : 1.0
// PHP version : PHP 7+
//
// Author      : Denis Patrice <denispatrice@yahoo.com>
// Copyright   : Copyright (c) Denis Patrice Dipl.-Ing. 2011, 2012
//               All rights reserved
//
// Application : Generic
// Description : SERVER AVAILABILITY AJAX API
//
// Date+Time of change   By     Description
// --------------------- ------ ----------------------------------------------
// 20-Jan-25 00:00 WIT   Denis  Deployment V. 2025 "Raymond Chandler"
//
// ============================================================================

// ****************************************************************************
// ****************************************************************************
//
// UTILS
//
// ****************************************************************************
// ****************************************************************************

// ipconfig command is a Windows command
//
function get_local_ip()
{
	$ip = "";
	try {
		if(function_exists('exec')) {
			$output = array();
			exec ("ipconfig", $output);
			foreach ($output as $line) {
				if (preg_match ("/(.*)IPv4 Address(.*)/", $line)) {
					$ip = substr($line, strrpos($line, ":") + 1);
					$ip = str_replace ("(Preferred)", "", $ip);
					$ip = trim($ip);
					break;
				}
			}
		}
	}
	catch (Exception $e) {
		$ip = "";
	}
	return $ip;
}


// ****************************************************************************
// ****************************************************************************
//
// MAIN
//
// ****************************************************************************
// ****************************************************************************

function main ()
{
	$errno  = 1000;
	$result = array();
	
	$result["phpversion"] = phpversion();
	$result["api"] = _URL_;

	$db = TDatabase::create("radiahub");
	if ($db->connect()) {
		$result["radiahub" ] = 'YES';
		$result["localhost"] = get_local_ip();
		$db->disconnect();
	}
	else {
		$errno = 1015;    // DATABASE ACCESS ERROR
	}

	$errstr = error_text ($errno);

	$result ["errno"  ] = $errno   ;
	$result ["errstr" ] = $errstr  ;
	$result ["instant"] = sql_timestamp();

	if (! headers_sent()) {
		header("Access-Control-Allow-Origin: *");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: -1");
  }
	
  echo json_encode ($result, JSON_PRETTY_PRINT);
	return $errno;
}

// ****************************************************************************
// ****************************************************************************
//
// CORE
//
// ****************************************************************************
// ****************************************************************************

error_reporting (E_ALL ^ E_DEPRECATED);
main ();


// End of file: ping.php
// ============================================================================
?>