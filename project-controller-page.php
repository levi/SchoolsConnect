<?php
/**
 * Template Name: Project Controller
 *
 */

require_once('social-page.php');

class ProjectController extends RestController
{
	protected $table = "school_projects";

	/** 
	   A compromise had to be made here. On account of the limitations
	   of Wordpress, nesting of REST paths are a pain in the ass.
	   Reverted to using the single "GET" id to be the school_id
	   identifier. 
	 */
	protected function get()
	{
		$school_id = $this->request->getGuid();
		$table = "{$this->db->prefix}{$this->table}";
		$projects = $this->db->get_results( $this->db->prepare( "SELECT * FROM $table WHERE school_id = $school_id" ) );
		
		$data = array();

		if ($projects) 
		{
			foreach ($projects as $project) 
			{
				$data[] = array(
					'id'		 => (int) $project->id,
					'name'       => $project->name,
					'amount'     => $project->amount,
					'created_at' => strtotime($project->created_at)*1000,
					'updated_at' => strtotime($project->updated_at)*1000,
				);
			}
		}

		RestUtils::sendResponse(200, json_encode($data));
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

				case 'name':
					$data[$key] = htmlentities( $value );
				break;
				
				case 'amount':
					if ( preg_match("/^(\d+).(\d+)$/", $value, $matches) ) 
					{
						$ret = $matches[1].'.'.str_pad($matches[2], 2, "0", STR_PAD_LEFT);
					}
					else
					{
						$ret = "0.00";
					}

					$data[$key] = $ret;
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

new ProjectController;