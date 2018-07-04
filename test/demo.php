<?php

// This demonstrates the usage of the NuSOAP adapter. It requires the 
// PhpWsdl framework files to be in the same folder as this file.
//
// Note: The NuSOAP adapter won't work with the PhpWsdlProxy!

// Load NoSOAP
//require_once('nusoap.php');// Change this to the location of your NuSOAP installation

require_once('../vendor/autoload.php');

// Load PhpWsdl
//require_once('class.phpwsdl.nusoap.php');

// Load the NuSOAP extension, if PhpWsdl could not do it 
// (because the "glob" function may be disabled in your PHP installation)
// If "glob" is working, you don't need the following two lines:
if(!class_exists('PhpWsdlNuSOAP')) 
	require_once('class.phpwsdl.nusoap.php');

// Run the SOAP server in quick mode
$soap=PhpWsdl::RunQuickMode(
	Array(								// All files with WSDL definitions in comments
		'class.soapdemo.php',
		'class.complextypedemo.php'
	)
);

// I was able to use this webservice with SoapUI. But with Visual Studio 2010 
// I didn't receive the response. I think the problem may be the dot in the 
// response XML tag names that are produced by NuSOAP when registering a 
// method of a class. But without the dot NuSOAP won't find the method. There 
// is no way to change the class->method delimiter in NuSOAP (or you need to 
// touch their code). So I'm sorry, but this may not work with .NET clients...
//
// A solution for this problem would be to use only global methods. Then 
// Visual Studio would be able to consume the webservice.
