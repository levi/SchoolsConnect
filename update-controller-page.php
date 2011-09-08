<?php
/**
 * Template Name: Update Controller
 *
 */

require_once('social-page.php');

/**
* 
*/
class UpdateController extends RestController
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
		$vars = $this->request->getRequestVars();
		$offset = ((int) $vars['offset'] > 0) ? $vars['offset'] : 1;
		$page_offset = ($offset - 1) * 3;
		$table = "{$this->db->prefix}school_updates";
		$updates = $this->db->get_results( $this->db->prepare( "SELECT * FROM $table WHERE school_id = $school_id LIMIT $page_offset, 3" ) );
		
		$data = array( 'models' => array(), 'total' => 0, 'offset' => 1, );

		if ($updates) 
		{
			$update_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM $table WHERE school_id = $school_id" ) );
			$data['total'] = (int) $update_count;
			$data['offset'] = (int) $offset;

			foreach ($updates as $update) 
			{
				$data['models'][] = array(
					'id'		 => (int) $update->id,
					'title'      => $update->title,
					'excerpt'    => $update->excerpt,
					'content'    => $update->content,
					'permalink'  => $update->permalink,
					'school_id'  => (int) $update->school_id,
					'created_at' => strtotime($update->created_at),
					'updated_at' => strtotime($update->updated_at),
				);
			}
		}

		RestUtils::sendResponse(200, json_encode($data));
	}
}

new UpdateController;