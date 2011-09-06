<?php
/**
 * Template Name: School Info Controller
 *
 */

require_once('social-page.php');

/**
* 
*/
class InfoController extends RestController
{
	protected function getList()
	{
		$vars = $this->request->getRequestVars();
		$offset = ((int) $vars['offset'] > 0) ? $vars['offset'] : 1;
		$page_offset = ($offset - 1) * 9;
		$table = "{$this->db->prefix}school_info";
		$schools = $this->db->get_results("SELECT * FROM $table LIMIT $page_offset, 9");
		
		if ($schools) 
		{
			$data = array( 'models' => array() );

			$school_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM $table;" ) );
			$data['total'] = (int) $school_count;
			$data['offset'] = (int) $offset;

			foreach ($schools as $school) {
				$data['models'][] = array(
					'id'         => $school->school_id,
					'name'       => $school->name,
					'image'      => $school->image,
					// 'goal'       => (int) $school->goal,
					// 'address'    => $school->address,
					// 'city'       => $school->city,
					// 'state'      => $school->state,
					// 'zipcode'    => $school->zipcode,
					// 'advisor'    => $school->advisor,
					// 'leaders'    => explode(', ', $school->leaders),
					// 'members'    => explode(', ', $school->members)
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
		$school_info = $this->db->get_row("SELECT * FROM {$this->db->prefix}school_info WHERE school_id = {$this->request->getGuid()}");

		if ($school_info) 
		{
			$data = array(
				'id'         => $school_info->school_id,
				'name'       => $school_info->name,
				'image'      => $school_info->image,
				'goal'       => (int) $school_info->goal,
				'address'    => $school_info->address,
				'city'       => $school_info->city,
				'state'      => $school_info->state,
				'zipcode'    => $school_info->zipcode,
				'advisor'    => $school_info->advisor,
				'leaders'    => explode(', ', $school_info->leaders),
				'members'    => explode(', ', $school_info->members),
				'is_admin'   => (bool) ($school_info->school_id == $this->user->ID),
			);

			RestUtils::sendResponse(200, json_encode($data));			
		}
		else
		{
			RestUtils::sendResponse(404);			
		}
	}
}

new InfoController;