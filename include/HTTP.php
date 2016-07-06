<?php
class HTTP {
	#===============================================================================
	# Eigenschaften: Zugriff auf die drei Request-Variablen
	#===============================================================================
	private static $GET  = NULL;
	private static $POST = NULL;
	private static $FILE = NULL;

	#===============================================================================
	# Konstanten: HTTP-Headerfelder
	#===============================================================================
	const HEADER_CONTENT_TYPE      = 'Content-Type';
	const HEADER_TRANSFER_ENCODING = 'Transfer-Encoding';
	const HEADER_ACCESS_CONTROL    = 'Access-Control-Allow-Origin';

	#===============================================================================
	# Konstanten: Werte für die HTTP-Headerfelder
	#===============================================================================
	const CONTENT_TYPE_JSCRIPT = 'application/x-javascript; charset=UTF-8';
	const CONTENT_TYPE_TEXT    = 'text/plain; charset=UTF-8';
	const CONTENT_TYPE_HTML    = 'text/html; charset=UTF-8';
	const CONTENT_TYPE_JSON    = 'application/json; charset=UTF-8';
	const CONTENT_TYPE_XML     = 'text/xml; charset=UTF-8';

	#===============================================================================
	# Initialisiert die Eigenschaften $GET, $POST und $FILE
	#===============================================================================
	public static function init($trimValues = TRUE) {
		self::$GET  = ($trimValues === TRUE ? self::trim($_GET)  : $_GET );
		self::$POST = ($trimValues === TRUE ? self::trim($_POST) : $_POST);
		self::$FILE = $_FILES;
	}

	#===============================================================================
	# Gibt eine valide Statuscodezeile für den HTTP Response-Header zurück
	#===============================================================================
	private static function getStatuscode($code) {
		return [
			200 => 'HTTP/1.1 200 OK',
			301 => 'HTTP/1.1 301 Moved Permanently',
			302 => 'HTTP/1.1 302 Found',
			303 => 'HTTP/1.1 303 See Other',
			307 => 'HTTP/1.1 307 Temporary Redirect',
			400 => 'HTTP/1.1 400 Bad Request',
			401 => 'HTTP/1.1 401 Authorization Required',
			403 => 'HTTP/1.1 403 Forbidden',
			404 => 'HTTP/1.1 404 Not Found',
			500 => 'HTTP/1.1 500 Internal Server Error',
			503 => 'HTTP/1.1 503 Service Temporarily Unavailable',
		][$code];
	}

	#===============================================================================
	# Trimmt alle Strings im übergebenen Parameter (auch Arrays)
	#===============================================================================
	private static function trim($mixed) {
		if(is_array($mixed)) {
			return array_map('self::trim', $mixed);
		}

		return trim($mixed);
	}

	#===============================================================================
	# Prüft ob alle Elemente von $arguments als $data-Schlüssel gesetzt sind
	#===============================================================================
	private static function issetData($data, $arguments) {
		foreach($arguments as $key) {
			if(is_array($key)) {
				if(!isset($data[key($key)]) OR $data[key($key)] !== $key[key($key)]) {
					return FALSE;
				}
			}

			else if(!isset($data[$key]) OR !is_string($data[$key])) {
				return FALSE;
			}
		}

		return TRUE;
	}

	#===============================================================================
	# Gibt den Wert aus einen der drei Eigenschaften anhand von $paths zurück
	#===============================================================================
	public static function returnKey($data, Array $paths) {
		$current = &$data;

		foreach($paths as $path) {
			if(!isset($current[$path]) OR (!is_string($current[$path]) AND !is_array($current[$path]))) {
				return NULL;
			}
			$current = &$current[$path];
		}

		return $current;
	}

	#===============================================================================
	# GET-Wert abfragen
	#===============================================================================
	public static function GET() {
		return self::returnKey(self::$GET, func_get_args());
	}

	#===============================================================================
	# POST-Wert abfragen
	#===============================================================================
	public static function POST() {
		return self::returnKey(self::$POST, func_get_args());
	}

	#===============================================================================
	# FILE-Wert abfragen
	#===============================================================================
	public static function FILE() {
		return self::returnKey(self::$FILE, func_get_args());
	}

	#===============================================================================
	# Prüft ob alle Elemente von $keys als $_POST-Schlüssel gesetzt sind
	#===============================================================================
	public static function issetPOST() {
		return self::issetData(self::$POST, func_get_args());
	}

	#===============================================================================
	# Prüft ob alle Elemente von $keys als $_GET-Schlüssel gesetzt sind
	#===============================================================================
	public static function issetGET() {
		return self::issetData(self::$GET, func_get_args());
	}

	#===============================================================================
	# Prüft ob alle Elemente von $keys als $_GET-Schlüssel gesetzt sind
	#===============================================================================
	public static function issetFILE() {
		return self::issetData(self::$FILE, func_get_args());
	}

	#===============================================================================
	# Gibt die HTTP-Anfragemethode zurück oder prüft diese
	#===============================================================================
	public static function requestMethod($method = NULL) {
		if(!empty($method)) {
			return ($_SERVER['REQUEST_METHOD'] === $method);
		}

		return $_SERVER['REQUEST_METHOD'];
	}

	#===============================================================================
	# Gibt die relativ aufgerufene URL zurück
	#===============================================================================
	public static function requestURI() {
		return $_SERVER['REQUEST_URL'] ?? FALSE;
	}

	#===============================================================================
	# Inhalt des User-Agent:-Feldes im HTTP-Header
	#===============================================================================
	public static function useragent() {
		return trim($_SERVER['HTTP_USER_AGENT'] ?? '');
	}

	#===============================================================================
	# Inhalt des Referer:-Feldes im HTTP-Header
	#===============================================================================
	public static function referer() {
		return trim($_SERVER['HTTP_REFERER'] ?? '');
	}

	#===============================================================================
	# Gibt den HTTP-Statuscode der aktuellen Anfrage zurück oder sendet ihn
	#===============================================================================
	public static function responseStatus($code = NULL) {
		if(!empty($code)) {
			return self::sendHeader(self::getStatuscode($code));
		}
		return http_response_code();
	}

	#===============================================================================
	# Sendet eine Headerzeile an den Client
	#===============================================================================
	public static function responseHeader($field, $value) {
		self::sendHeader("{$field}: {$value}");
	}

	#===============================================================================
	# Sendet einen HTTP-Redirect an den Client
	#===============================================================================
	public static function redirect($location, $code = 303, $exit = TRUE) {
		self::sendHeader(self::getStatuscode($code));
		self::sendHeader("Location: {$location}");
		$exit AND exit();
	}

	#===============================================================================
	# Sendet eine neue Headerzeile an den Client wenn noch keine Ausgabe gemacht wurde
	#===============================================================================
	private static function sendHeader($header) {
		if(!headers_sent()) {
			header($header);
		}
	}
}
?>