<?php
/**
 * Template Name: Profile Photo Uploader
 *
 */

class UploadPhoto
{
	const MAX_SIZE = "3145728";

	private $db;

	public $guid;
	public $script_dir;
	public $upload_dir;

	private $type;
	private $filename;

	function __construct($db, $user)
	{
		$this->user = $user;
		$this->db = $db;

		$this->script_dir = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
		$this->upload_dir = $this->script_dir.'/wp-content/uploads/profile_photos';
	}

	public function process_upload()
	{
		if ( ! isset($_FILES['userfile']) ) exit;

		if ($_FILES['userfile']['size'] > self::MAX_SIZE) 
		{
			echo json_encode(array('error' => 'File is too big to upload. Needs to be under 3MB.'));
			exit;
		}

		$this->type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];

		if (is_uploaded_file($tmp_name)) 
		{
			if ( ( $this->type == "image/gif" ) OR 
				 ( $this->type == "image/jpg" ) OR 
				 ( $this->type == "image/bmp" ) OR 
				 ( $this->type == "image/png" ) OR 
				 ( $this->type == "image/jpeg" ) ) 
			{
				$filepath = $this->build_filename($this->upload_dir, $type);

				while (file_exists($filepath)) 
				{	
					$filepath = $this->build_filename($upload_directory, $type);
				}

				if ( move_uploaded_file($tmp_name, $filepath) ) 
				{
					if ($this->db->update( $this->db->prefix.'school_info', 
									   array( 'image' => $this->filename ), 
									   array( 'school_id' => $this->user->ID ) )) {
						echo json_encode( array( 'image' => $this->filename ) );
					}
					else
					{
						throw new Exception("Failed to save to DB");
					}
				}
				else
				{
					echo json_encode( array( 'error' => 'Failed to upload.' ) );
				}
			}
			else
			{
				echo json_encode( array( 'error' => 'Wrong file type. Only jpg, png, and gif supported.' ) );				
			}
		}
		else 
		{
			echo json_encode(array('error' => 'Not properly uploaded.'));
			exit;
		}

	}

	private function build_filename()
	{
		$this->guid = $this->create_guid();

		switch ($this->type) 
		{
			case 'image/gif':
				$ext = '.gif';
			break;
			
			case 'image/jpg':
				$ext = '.jpg';
			break;

			case 'image/png':
				$ext = '.png';
			break;

			case 'image/jpeg':
				$ext = '.jpeg';
			break;
		}

		$this->filename = $this->guid.$ext;

		return $this->upload_dir.'/'.$this->filename;
	}

	private function create_guid()
	{
		return substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
	}
}

get_currentuserinfo();

$upload = new UploadPhoto($wpdb, $current_user);
$upload->process_upload();

?>