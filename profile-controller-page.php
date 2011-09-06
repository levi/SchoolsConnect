<?php
/**
 * Template Name: Profile Controller
 *
 */

require_once('social-page.php');

/**
* 
*/
class ProfileController extends RestController
{
	protected function get()
	{
		$school_id = $this->request->getGuid();
		$school_info = $this->db->get_row("SELECT * FROM {$this->db->prefix}school_info WHERE school_id = $school_id");

		if ($school_info) 
		{
			$data = array( 'updates' => array(), 'projects' => array() );

			$data['school'] = array(
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

			// School Updates (first 3)
			$updates = $this->db->get_results( "SELECT * FROM {$this->db->prefix}school_updates WHERE school_id = $school_id ORDER BY created_at DESC LIMIT 3" );

			if ($updates) {
				foreach ($updates as $update) {
					$data['updates'] = array(
						'id'		 => $update->id,
						'title'      => $update->title,
						'excerpt'    => $update->excerpt,
						'content'    => $update->content,
						'permalink'  => $update->permalink,
						'school_id'  => $update->school_id,
						'created_at' => strtotime($update->created_at),
						'updated_at' => strtotime($update->updated_at),
					);
				}
			}

			// School Projects (all of them)
			$projects = $this->db->get_results("SELECT * FROM {$this->db->prefix}school_projects WHERE school_id = $school_id ORDER BY created_at DESC");

			if ($projects) {
				foreach ($projects as $project) {
					$data['projects'] = array(
						'id'		 => $project->id,
						'name'       => $project->name,
						'amount'     => $project->amount,
						'created_at' => strtotime($project->created_at),
						'updated_at' => strtotime($project->updated_at),
					);
				}
			}

			RestUtils::sendResponse(200, json_encode($data));			
		}
		else
		{
			RestUtils::sendResponse(404);			
		}
	}
}

new ProfileController;