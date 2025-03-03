<?php require_once ("config.radia.php"); autoload();
// ============================================================================
// Module      : index.php
// Version     : 1.0
// PHP version : PHP 7+
//
// Author      : Denis Patrice <denispatrice@yahoo.com>
// Copyright   : Copyright (c) Denis Patrice Dipl.-Ing. 2011, 2012
//               All rights reserved
//
// Application : IAB
// Description : SERVER INTENTS API
//
// Date+Time of change   By     Description
// --------------------- ------ ----------------------------------------------
// 11-Feb-17 00:00 WIT   Denis  Deployment V. 2017 "ALEXANDRE DUMAS"
//
// ============================================================================

// ****************************************************************************
// ****************************************************************************
//
// IMPLEMENTATIONS
//
// ****************************************************************************
// ****************************************************************************

function intents($dataType, $data)
{

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
	$result = array();
	$done   = FALSE;
	$errno  = session();

	$options = array ('expires'=>time()+1800, 'path'=>'/', 'secure'=>B_SECURE_SESSIONS);

	setcookie("package_id", formvar("package_id"), $options);
	setcookie("device_id",  formvar("device_id"),  $options);
	setcookie("domURL",     _DOM_,                 $options);

	if ($errno === 1000) {
		$dataType = formvar("dataType");
		if (strlen($dataType) > 0) {
			$data = formvar("data");
			if (strlen($data) > 0) {
				$data = payload_decode($data);
				//Do something useful out of this information
				//like trigger intent, or set the application
				//entry point
				//
			}
			else {
				$data = array();
				$result["result"] = intents($dataType, $data);
			}
		}
		else {
			$filename = "app/html/index.html";
			$buffer = file2bin($filename);
			output($buffer);
			$done = TRUE;
		}
	}

	if (!$done) {
		$result["phpversion"] = phpversion();
		$result["api"] = _URL_;

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
	}

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


// End of file: index.php
// ============================================================================
?>