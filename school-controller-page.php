<?php
/**
 * Template Name: School Controller
 *
 */

require_once('social-page.php');

class SchoolController extends RestController
{
	var $table = "school_info";

	protected function getList()
	{
		$vars = $this->request->getRequestVars();
		$offset = ((int) $vars['offset'] > 0) ? $vars['offset'] : 1;
		$page_offset = ($offset - 1) * 9;
		$schools = $this->db->get_results("SELECT * FROM {$this->db->prefix}{$this->table} LIMIT $page_offset, 9");
		
		if ($schools) 
		{
			$data = array( 'models' => array() );

			$school_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM {$this->db->prefix}{$this->table};" ) );
			$data['total'] = (int) $school_count;
			$data['offset'] = (int) $offset;

			foreach ($schools as $school) {
				$data['models'][] = array(
					'id'         => $school->school_id,
					'name'       => $school->name,
					'image'      => $school->image,
				);
			}
			RestUtils::sendResponse(200, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(404);			
		}	
	}

	protected function get()
	{
		$school_id = $this->request->getGuid();
		$school = $this->db->get_row( $this->db->prepare( "SELECT * FROM {$this->db->prefix}{$this->table} WHERE school_id = $school_id" ) );
		
		if ($school) 
		{
			$data = array(
				'id'         => $school->school_id,
				'name'       => $school->name,
				'image'      => $school->image,
				'goal'       => (int) $school->goal,
				'address'    => $school->address,
				'address_2'  => $school->address_2,
				'city'       => $school->city,
				'state'      => $school->state,
				'zipcode'    => (int) $school->zipcode,
				'advisor'    => $school->advisor,
				'leaders'    => empty($school->leaders) ? array() : explode(', ', $school->leaders),
				'members'    => empty($school->members) ? array() : explode(', ', $school->members),
				'is_admin'   => (bool) ($school->school_id == $this->user->ID),
			);

			RestUtils::sendResponse(200, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(404);			
		}
	}
}

new SchoolController;