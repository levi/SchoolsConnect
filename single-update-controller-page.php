<?php
/**
 * Template Name: Single Update Controller
 *
 */

require_once('social-page.php');

/**
* 
*/
class SingleUpdateController extends RestController
{
	protected function get()
	{
		$update_id = $this->request->getGuid();
		$table = "{$this->db->prefix}school_updates";
		$update = $this->db->get_row( $this->db->prepare( "SELECT * FROM $table WHERE id = $update_id" ) );
		
		if ($update) 
		{
			$data = array(
				'id'		 => (int) $update->id,
				'title'      => $update->title,
				'excerpt'    => $update->excerpt,
				'content'    => $update->content,
				'permalink'  => $update->permalink,
				'school_id'  => (int) $update->school_id,
				'created_at' => strtotime($update->created_at),
				'updated_at' => strtotime($update->updated_at),
			);
	
			RestUtils::sendResponse(200, json_encode($data));
		}
		else
		{
			RestUtils::sendResponse(404);			
		}
	}
}

new SingleUpdateController;