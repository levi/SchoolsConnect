<?php
/**
 * Template Name: Single Update Controller
 *
 */

require_once('social-page.php');
require_once('lib/htmlpurifier-4.3.0/library/HTMLPurifier.auto.php');

class Helpers
{
	static public function create_slug( $string, $delimiter='-' )
	{
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
}

class SingleUpdateController extends RestController
{
	protected $table = 'school_updates';

	protected function get()
	{
		$update_id = $this->request->getGuid();
		$table = $this->db->prefix.$this->table;
		$update = $this->db->get_row( $this->db->prepare( "SELECT * FROM $table WHERE id = $update_id" ) );
		
		if ($update) 
		{
			$data = array(
				'id'		 => (int) $update->id,
				'title'      => $update->title,
				'content'    => $update->content,
				'permalink'  => $update->permalink,
				'school_id'  => (int) $update->school_id,
				'created_at' => strtotime($update->created_at)*1000,
				'updated_at' => strtotime($update->updated_at)*1000,
				'is_admin'   => (bool) ($update->school_id == $this->user->ID),
			);
	
			RestUtils::sendResponse(200, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(404);			
		}
	}

	protected function post()
	{
		$raw_data = $this->request->getData();
		$data = array( 'school_id' => $this->user->ID );

		foreach ($raw_data as $key => $value) 
		{
			switch ($key) 
			{
				case 'created_at':
				case 'updated_at':
					$data[$key] = date('Y-m-d H:i:s', strtotime($value));
				break;

				case 'title':
					$data[$key] = htmlentities( $value );

					// permalink
					$data['permalink'] = Helpers::create_slug($value);
				break;
				
				case 'content':
					$purifier = new HTMLPurifier();
				    $data[$key] = strip_tags($purifier->purify( $value ), '<p><a><br>');
				    
		    		// excerpt
					$excerpt = strip_tags($data['content']);
					$excerpt = explode(' ', $excerpt);
					$data['excerpt'] = implode(' ', array_slice($excerpt, 0, 50)).'...';	
				break;				
			}
		}

		if ($this->db->insert( $this->db->prefix.$this->table, $data )) 
		{
			$data['id'] = $this->db->insert_id;

			foreach ($data as $key => $value) {
				switch ($key) {
					case 'created_at':
					case 'updated_at':
						$data[$key] = (int) strtotime($value)*1000;
					break;
				}
			}
			RestUtils::sendResponse(201, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(500);
		}
	}

	protected function delete()
	{
		$school_id = $this->user->ID;
		$id = $this->request->getGuid();
		$query = "DELETE FROM {$this->db->prefix}{$this->table} WHERE school_id = {$this->user->ID} AND id = $id";

		if ( $this->db->query( $this->db->prepare($query) ) ) 
		{
			RestUtils::sendResponse(200);
		}
		else
		{
			RestUtils::sendResponse(404);
		}
	}
}

new SingleUpdateController;