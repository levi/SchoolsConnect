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
		$offset = ((int) $vars['offset'] > 1) ? ((int) $vars['offset'])-1 : 1;
		$page_offset = $offset * 12;
		$schools = $this->db->get_results( $this->db->prepare("SELECT * FROM {$this->db->prefix}{$this->table} ORDER BY id ASC LIMIT $page_offset, 12") );
		
		if ($schools) 
		{
			$data = array( 'models' => array() );

			$school_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM {$this->db->prefix}{$this->table};" ) );
			$data['total'] = (int) $school_count;
			$data['offset'] = (int) $offset+1;

			foreach ($schools as $school) {
				$projects = $this->db->get_results( $this->db->prepare( "SELECT * FROM {$this->db->prefix}school_projects WHERE school_id = {$school->school_id}" ) );
				$project_data = array();

				if ($projects) 
				{
					foreach ($projects as $project) 
					{
						$project_data[] = array(
							'id'		 => (int) $project->id,
							'name'       => $project->name,
							'amount'     => $project->amount,
							'created_at' => strtotime($project->created_at)*1000,
							'updated_at' => strtotime($project->updated_at)*1000,
						);
					}
				}

				$updates = $this->db->get_results( $this->db->prepare( "SELECT * FROM {$this->db->prefix}school_updates WHERE school_id = {$school->school_id} ORDER BY created_at DESC LIMIT 0, 3" ) );
				$update_data = array( 'models' => array(), 'total' => 0, 'offset' => 1, );

				if ($updates) 
				{
					$update_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM {$this->db->prefix}school_updates WHERE school_id = {$school->school_id}" ) );
					$update_data['total'] = (int) $update_count;

					foreach ($updates as $update) 
					{
						$update_data['models'][] = array(
							'id'		 => (int) $update->id,
							'title'      => $update->title,
							'excerpt'    => $update->excerpt,
							'permalink'  => $update->permalink,
							'school_id'  => (int) $update->school_id,
							'created_at' => strtotime($update->created_at)*1000,
							'updated_at' => strtotime($update->updated_at)*1000,
						);
					}
				}

				$data['models'][] = array(
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
					'_projects'   => $project_data,
					'_updates'    => $update_data,
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
			$projects = $this->db->get_results( $this->db->prepare( "SELECT * FROM {$this->db->prefix}school_projects WHERE school_id = {$school->school_id}" ) );
			$project_data = array();

			if ($projects) 
			{
				foreach ($projects as $project) 
				{
					$project_data[] = array(
						'id'		 => (int) $project->id,
						'name'       => $project->name,
						'amount'     => $project->amount,
						'created_at' => strtotime($project->created_at)*1000,
						'updated_at' => strtotime($project->updated_at)*1000,
					);
				}
			}

			$updates = $this->db->get_results( $this->db->prepare( "SELECT * FROM {$this->db->prefix}school_updates WHERE school_id = {$school->school_id} ORDER BY created_at DESC LIMIT 0, 3" ) );
			$update_data = array( 'models' => array(), 'total' => 0, 'offset' => 1, );

			if ($updates) 
			{
				$update_count = $this->db->get_var( $this->db->prepare( "SELECT COUNT(*) FROM {$this->db->prefix}school_updates WHERE school_id = {$school->school_id}" ) );
				$update_data['total'] = (int) $update_count;

				foreach ($updates as $update) 
				{
					$update_data['models'][] = array(
						'id'		 => (int) $update->id,
						'title'      => $update->title,
						'excerpt'    => $update->excerpt,
						'permalink'  => $update->permalink,
						'school_id'  => (int) $update->school_id,
						'created_at' => strtotime($update->created_at)*1000,
						'updated_at' => strtotime($update->updated_at)*1000,
					);
				}
			}
			
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
				'_projects'   => $project_data,
				'_updates'    => $update_data,
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