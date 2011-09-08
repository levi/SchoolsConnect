<?php
/**
 * Template Name: Project Controller
 *
 */

require_once('social-page.php');

class ProjectController extends RestController
{
	/** 
	   A compromise had to be made here. On account of the limitations
	   of Wordpress, nesting of REST paths are a pain in the ass.
	   Reverted to using the single "GET" id to be the school_id
	   identifier. 
	 */
	protected function get()
	{
		$school_id = $this->request->getGuid();
		$table = "{$this->db->prefix}school_projects";
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
					'created_at' => strtotime($project->created_at),
					'updated_at' => strtotime($project->updated_at),
				);
			}
		}

		RestUtils::sendResponse(200, json_encode($data));
	}
}

new ProjectController;