<?php
/* 
	Developed by David Regimbal (aka TACTICS)
	
	Use in accordance with Microsoft's Terms of Use/Service
	In order to work you must supply a valid account
	
	The supplier, you the account holder, are 
	responsible for whatever happens to your account
	and how it is used / manipulated
	
	Include this file on all pages needing access to the API
	
*/

#Microsoft Account Details
$email = "EMAIL ADDRES AT XBOX.COM";
$password = "PASSWORD AT XBOX.COM";
#end

#Require
require_once('auth.php');
require_once('construct.php');
#end

#Get Spartan Token
$auth = new Auth();
$tokens = $auth->getSpartanToken($email, $password);
#end