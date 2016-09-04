<?php
#====================================================================================================
# Include HTTP class
#====================================================================================================
require_once('include/HTTP.php');

#====================================================================================================
# [DEPRECATED] Initialize HTTP class
#====================================================================================================
HTTP::init();

#====================================================================================================
# EXAMPLE: Checks if GET parameters are set
#====================================================================================================
if(HTTP::issetGET('parameter_one', 'parameter_two', 'parameter_three')) {
	$parameter_one = HTTP::GET('parameter_one');
	$parameter_two = HTTP::GET('parameter_two');

	var_dump($parameter_one, $parameter_two, HTTP::GET('parameter_three'));
}

#====================================================================================================
# EXAMPLE: Checks if POST parameters are set
#====================================================================================================
if(HTTP::issetPOST('parameter_one', 'parameter_two', 'parameter_three')) {
	$parameter_one = HTTP::POST('parameter_one');
	$parameter_two = HTTP::POST('parameter_two');

	var_dump($parameter_one, $parameter_two, HTTP::POST('parameter_three'));
}

#====================================================================================================
# EXAMPLE: Checks if POST parameters in combination with a specific value are set
#====================================================================================================
if(HTTP::issetPOST('parameter_one', 'parameter_two', ['parameter_three' => 'value_three'])) {
	// do something
}

#====================================================================================================
# EXAMPLE: Checks the HTTP request method
#====================================================================================================
if(HTTP::requestMethod('GET') OR HTTP::requestMethod('POST') OR HTTP::requestMethod('HEAD')) {
	// do something
}

#====================================================================================================
# EXAMPLE: Get the HTTP request method
#====================================================================================================
$requestMethod = HTTP::requestMethod();

#====================================================================================================
# EXAMPLE: Get the HTTP status code of the current request
#====================================================================================================
$statusCode = HTTP::responseStatus();

#====================================================================================================
# EXAMPLE: Sends a HTTP status code to the client
#====================================================================================================
HTTP::responseStatus(200);

#====================================================================================================
# EXAMPLE: Sends a custom HTTP response header to the client
#====================================================================================================
HTTP::responseHeader(HTTP::HEADER_CONTENT_TYPE, HTTP::CONTENT_TYPE_TEXT);

#====================================================================================================
# EXAMPLE: Sends a HTTP redirect to the client and stop script execution
#====================================================================================================
# HTTP::redirect('https://example.org/');
# HTTP::redirect('https://example.org/', 303);
?>