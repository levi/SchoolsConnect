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
				);
			}
			RestUtils::sendResponse(200, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(404);			
		}	
	}
}

new InfoController;