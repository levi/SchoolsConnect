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
		$this->request = RestUtils::processRequest();

		$method = ($this->request->getMethod() == 'get' AND $this->request->getGuid() == FALSE) ? 'getList' : $this->request->getMethod();
		
		$this->beforeFilter();
		$this->{$method}();
	}

	protected function beforeFilter()
	{
		
	}

	/**
	 * If the request method isn't implemented, notify the client.
	 */
	public function __call($name, $arguments)
	{
		RestUtils::sendResponse(501);
	}
}

// if ( ! is_user_logged_in() ) die('Need to be logged in');

// require_once 'lib/htmlpurifier-4.3.0/library/HTMLPurifier.auto.php';

// /**
// * Helpers for doing various things in the REST_Dispatch class.
// */
// class Helpers
// {
// 	static public function create_slug( $string, $delimiter='-' )
// 	{
// 		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
// 		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
// 		$clean = strtolower(trim($clean, '-'));
// 		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

// 		return $clean;
// 	}

// 	static public function jsonify( $data )
// 	{
// 		if (is_array($data[0])) 
// 		{
// 			for ($i=0; $i < count($data); $i++) 
// 			{ 
// 				$data[$i] = self::process_data_element($data[$i]);
// 			}
// 		}
// 		else
// 		{
// 			$data = self::process_data_element($data);
// 		}

// 		return json_encode( $data );
// 	}

// 	private function process_data_element($data)
// 	{
// 		if ( array_key_exists('created_at', $data) )
// 			$data['created_at'] = strtotime( $data['created_at'] );

// 		if ( array_key_exists('updated_at', $data) )
// 			$data['updated_at'] = strtotime( $data['updated_at'] );
		
// 		return $data;
// 	}
// }

// class REST_Dispatch
// {
// 	public $db;
// 	public $user;

// 	public $params;
// 	public $type;
// 	public $request_type;

// 	public $body;

// 	public $table_name;

// 	public $TYPE_TABLE_NAMES = array(
// 		'update'  => 'school_updates',
// 		'project' => 'school_projects',
// 		'school'  => 'school_info',
// 	);

// 	public $TYPE_PROPERTIES = array(
// 		'update' => array(
// 			'title' => array( 'encode', ),
// 			'content' => array( 'html', ),
// 		),
// 		'project' => array(
// 			'name' => array( 'encode' ),
// 			'amount' => array( 'currency' )
// 		),
// 	);

// 	function __construct($db, $user, $logger)
// 	{
// 		$this->db = $db;
// 		$this->user = $user;
// 		$this->logger = $logger;
// 		$this->process_request();
// 	}

// 	public function parse_request()
// 	{
// 		$this->params = $_GET;
// 		$content_type = $this->params['type'];

// 		if ( ! empty($content_type) ) 
// 		{
// 			if (array_key_exists($content_type, $this->TYPE_TABLE_NAMES)) 
// 			{
// 				$this->type = $content_type;
// 			}
// 			else
// 			{
// 				$this->error("Invalid content type");
// 			}

// 			$this->table_name = $this->db->prefix.$this->TYPE_TABLE_NAMES[$this->type];
// 		}

// 		// force read on non-type requests, since it's just a bulk reading of all types.
// 		$this->request_type = empty($content_type) ? 'GET' : $_SERVER['REQUEST_METHOD'];		
// 		$body = @file_get_contents('php://input');

// 		if ( ! empty($body) ) 
// 		{
// 			$this->body = json_decode($body);
// 		}
// 	}

// 	public function process_request()
// 	{
// 		$this->parse_request();

// 		switch ($this->request_type) 
// 		{
// 			case 'GET':
// 				$this->read();
// 			break;

// 			case 'POST':
// 				$this->create();
// 			break;

// 			case 'PUT':
// 				$this->update();
// 			break;

// 			case 'DELETE':
// 				$this->destroy();
// 			break;
// 		}
// 	}

// 	private function tsa_data()
// 	{
// 		$data = $this->body;
// 		$properties = $this->TYPE_PROPERTIES[$this->type];
// 		$ret = array();

// 		// Validation
// 		foreach ($properties as $key => $value) 
// 		{
// 			$property = trim($data->$key);

// 			if (is_array($value)) 
// 			{
// 				foreach ($value as $process) 
// 				{
// 					switch ($process) {
// 						case 'currency':
// 							if ( preg_match('/^(\d+).(\d+)$/', $property, $matches) ) 
// 							{
// 								$this->logger->log($matches);
// 								$property = $matches[1].'.'.str_pad($matches[2], 2, "0", STR_PAD_LEFT);
// 							}
// 							else
// 							{
// 								$property = 0.00;
// 							}
// 						break;

// 						case 'encode':
// 							$property = htmlentities( $property );
// 						break;

// 						case 'html':
// 							$purifier = new HTMLPurifier();
// 						    $property = $purifier->purify( $property );							
// 						break;
// 					}
// 				}
// 			}

// 			if ( ! empty( $property ) ) 
// 			{
// 				$ret[$key] = $property;
// 			}
// 			else
// 			{
// 				$this->error("Property failed validation");
// 			}
// 		}

// 		// Add properties
// 		switch ($this->type) 
// 		{
// 			case 'update':
// 				// excerpt
// 				$excerpt = strip_tags($ret['content']);
// 				$excerpt = explode(' ', $excerpt);
// 				$ret['excerpt'] = implode(' ', array_slice($excerpt, 0, 50)).'...';

// 				// dates
// 				$ret['created_at'] = $ret['updated_at'] = date('Y-m-d H:i:s');

// 				// permalink
// 				$ret['permalink'] = Helpers::create_slug($ret['title']);
// 			break;	
			
// 			case 'project':
// 				$ret['created_at'] = $ret['updated_at'] = date('Y-m-d H:i:s');
// 			break;		
// 		}

// 		// school id
// 		$ret['school_id'] = $this->user->ID;

// 		return $ret;
// 	}

// 	private function read()
// 	{
// 		$user_id = (int) $this->params['school_id'];

// 		// Requests without type don't need this query string.
// 		if ( ! empty($this->type) )
//     {
// 			$query = "SELECT * FROM $this->table_name";

//       // Use the passed school_id if available
//       if ( ! empty( $user_id ) AND is_int( $user_id ))
//         $query .= " WHERE school_id = $user_id";
//     }

// 		switch ($this->type) 
// 		{
// 			case 'update':
// 				$id = $this->params['id'];

// 				function cleanup($update)
// 				{
// 				  	return array(
// 						'id'		 => (int) $update->id,
// 						'title'      => $update->title,
// 						'excerpt'    => $update->excerpt,
// 						'content'    => $update->content,
// 						'permalink'  => $update->permalink,
// 						'school_id'  => (int) $update->school_id,
// 						'created_at' => $update->created_at,
// 						'updated_at' => $update->updated_at,
// 					);
// 				}

// 				if ( ! empty($id) && is_numeric($id) ) 
// 				{
// 					$query .= " AND id = $id LIMIT 0, 1";
// 					$update = $this->db->get_results($query);

// 					if ($update) 
// 					{
// 						$data = array_map('cleanup', $update);
// 						$data = $data[0];
// 					}
// 					else
// 					{
// 						$this->error('404');
// 					}
// 				}
// 				else
// 				{
// 					$offset = $this->params['offset'];

// 					if ( empty( $offset ) || ! is_numeric( $offset ) )
// 						$offset = 0;
						
// 					$query .= " ORDER BY created_at DESC LIMIT $offset, 3";
// 					$updates = $this->db->get_results($query);
// 					$data = array_map('cleanup', $updates);
// 				}

// 				echo Helpers::jsonify( $data );
// 			break;

// 			case 'project':					
// 				$query .= " ORDER BY created_at DESC";
// 				$updates = $this->db->get_results($query);

// 				function cleanup($update)
// 				{
// 				  	return array(
// 						'id'		 => (int) $update->id,
// 						'name'       => $update->name,
// 						'amount'     => $update->amount,
// 						'created_at' => $update->created_at,
// 						'updated_at' => $update->updated_at,
// 					);
// 				}

// 				$data = array_map('cleanup', $updates);

// 				echo Helpers::jsonify( $data );
// 			break;

// 			case 'school':
// 				$id = $this->params['id'];

// 				if ( ! empty($id) && is_numeric($id) ) 
// 				{
// 					$query .= " LIMIT 0, 1";
// 					$school = $this->db->get_results($query);

// 					if (count($school) == 1) 
// 					{
// 						echo Helpers::jsonify( array(
// 							'name'       => $school[0]->name,
// 							'image'      => $school[0]->image,
// 							'goal'       => (int) $school[0]->goal,
// 							'address'    => $school[0]->address,
// 							'city'       => $school[0]->city,
// 							'state'      => $school[0]->state,
// 							'zipcode'    => $school[0]->zipcode,
// 							'advisor'    => $school[0]->advisor,
// 							'leaders'    => explode(', ', $school[0]->leaders),
// 							'members'    => explode(', ', $school[0]->members),
// 							'school_id'  => $school[0]->school_id,
// 							'is_admin'   => (bool) ($school[0]->school_id == $this->user->ID),
// 						) );
// 					}
// 					else
// 					{
// 						echo $this->error('No school found');
// 					}
// 				}
// 				else
// 				{
// 					$offset = $this->params['offset'];

// 					if ( empty( $offset ) || ! is_numeric( $offset ) )
// 						$offset = 0;
						
// 					$query .= " ORDER BY id ASC LIMIT $offset, 9";
// 					$schools = $this->db->get_results($query);

//           function cleanup($school)
//           {
//               return array(
//               'id'         => (int) $school->school_id,
//               'name'       => $school->name,
//               'image'      => $school->image,
//               'goal'       => (int) $school->goal,
//               'address'    => $school->address,
//               'city'       => $school->city,
//               'state'      => $school->state,
//               'zipcode'    => $school->zipcode,
//               'advisor'    => $school->advisor,
//               'leaders'    => explode(', ', $school->leaders),
//               'members'    => explode(', ', $school->members),
//             );
//           }

// 					$data = array_map('cleanup', $schools);

//           echo Helpers::jsonify( $data );
// 				}
// 			break;

// 			// Bulk loads an entire school's profile.
// 			default:
// 				// School Info
// 				$school_query = "SELECT * FROM ".$this->db->prefix."school_info WHERE school_id = $user_id LIMIT 0, 1";
// 				$school = $this->db->get_results($school_query);

// 				$school_info = array(
// 					'name'       => $school[0]->name,
// 					'image'      => $school[0]->image,
// 					'goal'       => (int) $school[0]->goal,
// 					'address'    => $school[0]->address,
// 					'city'       => $school[0]->city,
// 					'state'      => $school[0]->state,
// 					'zipcode'    => $school[0]->zipcode,
// 					'advisor'    => $school[0]->advisor,
// 					'leaders'    => explode(', ', $school[0]->leaders),
// 					'members'    => explode(', ', $school[0]->members),
// 					'school_id'  => $school[0]->school_id,
// 					'is_admin'   => (bool) ($school[0]->school_id == $this->user->ID),
// 				);

// 				// School Updates (first 3)
// 				$updates_query = "SELECT * FROM ".$this->db->prefix."school_updates WHERE school_id = $user_id ORDER BY created_at DESC LIMIT 3";
// 				$updates = $this->db->get_results($updates_query);
// 				$school_updates = array();

// 				foreach ($updates as $update) {
// 					$school_updates[] = array(
// 						'id'		 => $update->id,
// 						'title'      => $update->title,
// 						'excerpt'    => $update->excerpt,
// 						'content'    => $update->content,
// 						'permalink'  => $update->permalink,
// 						'school_id'  => $update->school_id,
// 						'created_at' => strtotime($update->created_at),
// 						'updated_at' => strtotime($update->updated_at),
// 					);
// 				}

// 				// School Projects (all of them)
// 				$projects_query = "SELECT * FROM ".$this->db->prefix."school_projects WHERE school_id = $user_id ORDER BY created_at DESC";
// 				$projects = $this->db->get_results($projects_query);
// 				$school_projects = array(); 

// 				foreach ($projects as $project) {
// 					$school_projects[] = array(
// 						'id'		 => $project->id,
// 						'name'       => $project->name,
// 						'amount'     => $project->amount,
// 						'created_at' => strtotime($project->created_at),
// 						'updated_at' => strtotime($project->updated_at),
// 					);
// 				}

// 				echo json_encode( array(
// 					'school'   => $school_info,
// 					'updates'  => $school_updates,
// 					'projects' => $school_projects,
// 				) );
// 			break;
// 		}
// 	}

//   private function create()
// 	{
// 		$data = $this->tsa_data();

// 		if ( $this->db->insert( $this->table_name, $data ) ) 
// 		{
// 			$data['id'] = $this->db->insert_id;
// 			echo Helpers::jsonify( $data );
// 		}
// 		else
// 		{
// 			$this->error("Failed to save to database");
// 		}
// 	}

// 	private function update()
// 	{
// 		# code...
// 	}

// 	private function destroy()
// 	{

// 		$user_id = $this->user->ID;
// 		$id      = $this->params['id'];

// 		switch ($this->type) 
// 		{
// 			case 'project':
// 				$query = "DELETE FROM $this->table_name WHERE school_id = $user_id AND id = $id";
// 				if ($this->db->query($query)) 
// 				{
// 					echo json_encode( array( 'error' => 'Invalid request' ) );
// 				}
// 				else
// 				{
// 					$this->error("Failed to remove from database.");
// 				}
// 			break;
// 		}
// 	}

// 	private function error($message)
// 	{
// 		echo json_encode( array( 'error' => $message ) );
// 		exit();
// 	}
// }

// get_currentuserinfo();

// $dispatcher = new REST_Dispatch($wpdb, $current_user, $wplogger);