<?php
#====================================================================================================
# HTTP-Klasse einbinden
#====================================================================================================
require_once('include/class.http.php');

#====================================================================================================
# HTTP-Klasse initialisieren
#====================================================================================================
HTTP::init();

#====================================================================================================
# EXAMPLE: Prüfen, ob GET-Parameter gesetzt sind
#====================================================================================================
if(HTTP::issetGET('parameter_one', 'parameter_two', 'parameter_three')) {
	$parameter_one = HTTP::$GET['parameter_one'];
	$parameter_two = HTTP::$GET['parameter_two'];
}

#====================================================================================================
# EXAMPLE: Prüfen, ob POST-Parameter gesetzt sind
#====================================================================================================
if(HTTP::issetPOST('parameter_one', 'parameter_two', 'parameter_three')) {
	$parameter_one = HTTP::$POST['parameter_one'];
	$parameter_two = HTTP::$POST['parameter_two'];
}

#====================================================================================================
# EXAMPLE: Prüfen, ob POST-Parameter gesetzt sind (dritter Parameter mit Wertüberprüfung)
#====================================================================================================
if(HTTP::issetPOST('parameter_one', 'parameter_two', ['parameter_three' => 'value_three'])) {
	// do something
}

#====================================================================================================
# EXAMPLE: Die HTTP-Anfragemethode überprüfen
#====================================================================================================
if(HTTP::requestMethod('GET') OR HTTP::requestMethod('POST') OR HTTP::requestMethod('HEAD')) {
	// do something
}

#====================================================================================================
# EXAMPLE: Die HTTP-Anfragemethode zurückgeben
#====================================================================================================
$requestMethod = HTTP::requestMethod();

#====================================================================================================
# EXAMPLE: Den HTTP-Statuscode der aktuellen Anfrage zurückgeben
#====================================================================================================
$statusCode = HTTP::responseStatus();

#====================================================================================================
# EXAMPLE: Einen HTTP-Statuscode an den Client schicken
#====================================================================================================
HTTP::responseStatus(200);

#====================================================================================================
# EXAMPLE: Einen benutzerdefinierten HTTP-Response-Header an den Client schicken
#====================================================================================================
HTTP::responseHeader(HTTP::HEADER_CONTENT_TYPE, HTTP::CONTENT_TYPE_TEXT);

#====================================================================================================
# EXAMPLE: Eine HTTP-Weiterleitung an den Client schicken
#====================================================================================================
# HTTP::redirect('https://example.org/');
# HTTP::redirect('https://example.org/', 303);
?>
