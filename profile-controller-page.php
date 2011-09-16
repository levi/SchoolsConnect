<?php
/**
 * Template Name: Profile Controller
 *
 */

require_once('social-page.php');

/**
 * Profile Controller
 *
 * Batch fetching of a school club's profile.
 */
class ProfileController extends RestController
{
	protected $table = "school_info";

	protected function get()
	{
		$school_id = $this->request->getGuid();
		$table = $this->db->prefix.$this->table;
		$school_info = $this->db->get_row( $this->db->prepare( "SELECT * FROM $table WHERE school_id = $school_id" ) );

		if ($school_info) 
    {
			$data = array( 'updates' => array(), 'projects' => array() );

			$data['school'] = array(
				'id'         => $school_info->school_id,
				'name'       => $school_info->name,
				'image'      => $school_info->image,
				'goal'       => (int) $school_info->goal,
				'address'    => $school_info->address,
				'address_2'  => $school_info->address_2,
				'city'       => $school_info->city,
				'state'      => $school_info->state,
				'zipcode'    => $school_info->zipcode,
				'advisor'    => $school_info->advisor,
				'leaders'    => empty($school_info->leaders) ? array() : explode(', ', $school_info->leaders),
				'members'    => empty($school_info->members) ? array() : explode(', ', $school_info->members),
				'is_admin'   => (bool) ($school_info->school_id == $this->user->ID),
			);

			// School Updates (first 3)
			$updates = $this->db->get_results( $this->db->prepare( "SELECT * FROM $table WHERE school_id = $school_id ORDER BY created_at DESC LIMIT 3" ) );

			if ($updates) 
      {
				foreach ($updates as $update) 
        {
					$data['updates'] = array(
						'id'		     => $update->id,
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
			$projects = $this->db->get_results("SELECT * FROM $table WHERE school_id = $school_id ORDER BY created_at DESC");

			if ($projects) 
      {
				foreach ($projects as $project) 
        {
					$data['projects'] = array(
						'id'		     => $project->id,
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