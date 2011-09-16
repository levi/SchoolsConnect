<?php
/**
 * Template Name: Social API Page
 *
 */

get_currentuserinfo();

/**
* Utitlity to parse a REST request and dispatch data into
* the right instance vars for return processing.
*/
class RestUtils
{
	public static function processRequest()
	{
		global $wp_query;

		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$return_obj = new RestRequest();
		$data = array();

		switch ($request_method) 
		{
			case 'get':
				$data = $_GET;
			break;
			
			case 'post':
				$return_obj->setData( json_decode( file_get_contents('php://input') ) );
				$data = $_POST;
			break;
			
			case 'put':
				parse_str(file_get_contents('php://input'), $put_vars);
				$data = $put_vars;
			break;
		}

		$return_obj->setMethod($request_method);
		$return_obj->setRequestVars($data);

		if (isset($wp_query->query_vars['page']))
			$return_obj->setGuid((int) $wp_query->query_vars['page']);

		return $return_obj;
	}

	public static function sendResponse($status = 200, $body = '')
	{
		$status_header = 'HTTP/1.1 '.$status.' '.RestUtils::getStatusCodeMessage($status);
		header($status_header);
		header('Content-type: application/json');

		if ($body != '') 
		{
			echo $body;
			exit;
		}
		else
		{
			$message = '';

			switch ($status) {
				case 401:
					$message = 'You must be authorized to view this page.';
				break;
				
				case 404:
					$message = 'The requested URL '.$_SERVER['REQUEST_URI'].' was not found.';
				break;

				case 500:
					$message = 'The server encounted an error processing your request';
				break;

				case 501:
					$message = 'The requested method is not implemented';
				break;
			}

			echo json_encode( array( 'error' => array( 'status' => $status, 'message' => $message ) ) );
			exit;
		}
	}

	public static function getStatusCodeMessage($status)
	{
		$codes = Array(
		    100 => 'Continue',
		    101 => 'Switching Protocols',
		    200 => 'OK',
		    201 => 'Created',
		    202 => 'Accepted',
		    203 => 'Non-Authoritative Information',
		    204 => 'No Content',
		    205 => 'Reset Content',
		    206 => 'Partial Content',
		    300 => 'Multiple Choices',
		    301 => 'Moved Permanently',
		    302 => 'Found',
		    303 => 'See Other',
		    304 => 'Not Modified',
		    305 => 'Use Proxy',
		    306 => '(Unused)',
		    307 => 'Temporary Redirect',
		    400 => 'Bad Request',
		    401 => 'Unauthorized',
		    402 => 'Payment Required',
		    403 => 'Forbidden',
		    404 => 'Not Found',
		    405 => 'Method Not Allowed',
		    406 => 'Not Acceptable',
		    407 => 'Proxy Authentication Required',
		    408 => 'Request Timeout',
		    409 => 'Conflict',
		    410 => 'Gone',
		    411 => 'Length Required',
		    412 => 'Precondition Failed',
		    413 => 'Request Entity Too Large',
		    414 => 'Request-URI Too Long',
		    415 => 'Unsupported Media Type',
		    416 => 'Requested Range Not Satisfiable',
		    417 => 'Expectation Failed',
		    500 => 'Internal Server Error',
		    501 => 'Not Implemented',
		    502 => 'Bad Gateway',
		    503 => 'Service Unavailable',
		    504 => 'Gateway Timeout',
		    505 => 'HTTP Version Not Supported'
		);

		return (isset($codes[$status])) ? $codes[$status] : '';
	}
}

/**
* 
*/
class RestRequest
{
	private $request_vars;
	private $data;
	private $method;
	private $guid;

	function __construct()
	{
		$this->request_vars = array();
		$this->data = '';
		$this->method = 'get';
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setRequestVars($request_vars)
	{
		$this->request_vars = $request_vars;
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function setGuid($guid)
	{
		$this->guid = $guid;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getRequestVars()
	{
		return $this->request_vars;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getGuid()
	{
		return $this->guid;
	}
}

class RestController
{	
	protected $request;

	/**
	 * Process request on construction.
	 *
	 * Request method is set to getList if no id is passed in a get request.
	 * Otherwise a get request continues if and id is given.
	 */
	function __construct()
	{
		global $wpdb, $current_user;

		$this->db = $wpdb;
		$this->user = $current_user;

		if ($this->user->ID != 0) 
		{
			$this->request = RestUtils::processRequest();

			$method = ($this->request->getMethod() == 'get' AND $this->request->getGuid() == FALSE) ? 'getList' : $this->request->getMethod();
		
			$this->{$method}();
		}
		else
		{
			RestUtils::sendResponse(401);
		}
	}

	/**
	 * If the request method isn't implemented, notify the client.
	 */
	public function __call($name, $arguments)
	{
		RestUtils::sendResponse(501);
	}
}