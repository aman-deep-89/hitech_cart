<?php

namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\ForecastModel;
use App\Models\UserForecastModel;
use Myth\Auth\Models\UserModel;

class ImagePicker extends BaseController
{
	protected $config = array(
        'upload_dir' => '',
        'types' => array(
            'logo' => array(
                'crop_width'  => 600,  // Crop image to this width
                'crop_height' => 200,  // Crop image to this height
                'force_crop'  => false, // If the image width, height is less than crop_width, crop_weight force the crop
                'min_width'   => 300,  // Minimum width required 
                'min_height'  => 100,  // Minimum height required
                'max_width'   => null, // Maximum width allowed (null - not set)
                'max_height'  => null, // Maximum height allowed (null - not set)
                'original' => true, // If you want to keep the full size image
            ),
            'profile_img' => array(
                'crop_width'  => 200,  // Crop image to this width
                'crop_height' => 200,  // Crop image to this height
                'force_crop'  => true, // If the image width, height is less than crop_width, crop_weight force the crop
                'min_width'   => 200,  // Minimum width required 
                'min_height'  => 200,  // Minimum height required
                //'max_width'   => null, // Maximum width allowed (null - not set)
                //'max_height'  => null, // Maximum height allowed (null - not set)
                'original' => true, // If you want to keep the full size image
            ),
            
            'favicon' => array(
                'crop_width'  => 20,  // Crop image to this width
                'crop_height' => 20,  // Crop image to this height
                'force_crop'  => true, // If the image width, height is less than crop_width, crop_weight force the crop
                'min_width'   => 20,  // Minimum width required 
                'min_height'  => 20,  // Minimum height required
                //'max_width'   => null, // Maximum width allowed (null - not set)
                //'max_height'  => null, // Maximum height allowed (null - not set)
                'original' => false, // If you want to keep the full size image
            ),            
        ),
        'max_file_size' => 10000, // in KB (1000KB = 1MB)
        'image_types' => 'jpg|png|jpeg|gif', // Allowed image extensions
        'error_messages' => array(
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk',
            8 => 'A PHP extension stopped the file upload',
            'upload_failed' => 'Failed to upload the file',
            'move_failed' => 'Failed to move the uploaded file',
            'max_file_size' => 'File is too big',
            'min_file_size' => 'File is too small',
            'accept_file_types' => 'Filetype not allowed',
            'max_width' => 'Image exceeds maximum width of ',
            'min_width' => 'Image requires a minimum width of ',
            'max_height' => 'Image exceeds maximum height of ',
            'min_height' => 'Image requires a minimum height of ',
            'undefined_type' => 'Undefined type',
        )
    );
	private $upload_dir;

	function __construct() {
		$this->upload_dir = FCPATH.'public/uploads/';
	}

	// Function for the iframe upload
	public function upload($file, $type = '', $obj_id = null) {
        if (!isset($file['tmp_name'])) {
			$this->json_error( $this->error('upload_failed') );
		}
		
		if ( !array_key_exists($type, $this->config('types')) ) {
			$this->json_error( $this->error('undefined_type') );
		}
		
		if ($file['error']) {
			$this->json_error( $this->error($file['error']) );
		}
		
		if ($file['size'] > $this->config('max_file_size') * 100) {
			$this->json_error( $this->error('max_file_size') );
		}
		
		if (!preg_match('/.('.$this->config('image_types').')+$/i', $file['name'])) {
			$this->json_error( $this->error('accept_file_types') );
		}

		if (!is_dir($this->upload_dir)) {
			mkdir($this->upload_dir, 0755);
		}
		$time=time();
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		$filename = $this->get_filename($obj_id, $type).".$ext";
		
		$path = $this->upload_dir.basename('_'.$filename);
		
		if (!move_uploaded_file($file['tmp_name'], $path)) {
			$this->json_error( $this->error('move_failed') );
		}
		
		$this->check_image_size($path, $type);

		$_SESSION['_imgPicker'] = $filename;
		$this->json_success( $this->get_full_url()."/$path" );
		 
	}

	public function save_cropped($data) {					
		$obj_id = $data['obj_id'];
		$type   = $data['type'];
		$config = $this->config("types/$type");
		$image_data = explode(',', $data['image']);
		
		if ( !array_key_exists($type, $this->config('types') )) {
			$this->json_error( $this->error('undefined_type') );
		}			
		// The image was uploaded with the iframe upload function
		if (empty($image_data[1])) {
			$filename = @$_SESSION['_imgPicker'];
			$original_path = $this->upload_dir.'_'.$filename;
			$path = $this->upload_dir.$filename;
			
			if (!is_file($original_path) || !@rename($original_path, $path)) {
				$this->json_error( $this->error('upload_failed') );
			}			
		}
		// The image is sent as base64 data
		else {
			$extension=substr($image_data[0],strpos($image_data[0],'/')+1,-7);
			$filename = $this->get_filename($obj_id, $type) . ".".$extension;			
            $path = $this->upload_dir.'/'.$filename;
			$original_path = $this->upload_dir."_$filename";
			$size = round((strlen($image_data[1]) - 814) / 1.37);
			if ($size > $this->config('max_file_size') * 1000) {
				$this->json_error( $this->error('max_file_size') );
			} 
		    
		    $handle = fopen($path , 'wb'); 
		    if (!$handle || empty($image_data[1])) {
		    	$this->json_error( $this->error('upload_failed') );
		    }
		    fwrite($handle, base64_decode($image_data[1]) ); 
		    fclose($handle);
		}

		//Make a copy for the original
	    if (isset($config['original'])) {
	    	@copy($path, $original_path);
	    }

		$this->check_image_size($path, $type);

		$crop_width  = @$config['crop_width'];
		$crop_height = @$config['crop_height'];
		$force_crop  = !empty($config['force_crop']) ? true : false;
		$image_width = $data['width'];
		$image_height = $data['height'];

		if (!empty($crop_width)) {
			if ( ($image_width > $crop_width) || ($image_width < $crop_width && $force_crop) ) {
				$new_width = $crop_width;
				$new_height = $image_height / $image_width * $crop_width;
			}
		} elseif (!empty($crop_height)) {
			if ( ($image_height > $crop_height) || ($image_height < $crop_height && $force_crop) ) {
				$new_height = $crop_height;
				$new_width = $image_width / $image_height * $crop_height;
			}
		}

		// Crop image
		$this->crop_image($path, $image_width, $image_height, $data['x'], $data['y'], @$new_width, @$new_height);

		// Save image to database callback
		
		// Return cropped image
		$this->json_success( site_url('public/uploads')."/$filename" );
	}

	private function crop_image($path, $width, $height, $x, $y, $new_width = null, $new_height = null) {
		list($imagewidth, $imageheight, $image_type) = getimagesize($path);
	    
	    $image_type = image_type_to_mime_type($image_type);
	    $new_width = ($new_width) ? ceil($new_width) : $width;
	    $new_height = ($new_height) ? ceil($new_height) : $height;
		$new_image = imagecreatetruecolor($new_width, $new_height);			
	    switch ($image_type) {
			case 'image/gif':
				$source = imagecreatefromgif($path); 
				imagealphablending( $new_image, false );
				imagesavealpha( $new_image, true );
	        break;
	        case 'image/pjpeg':
	        case 'image/jpeg':
			case 'image/jpg':
				$white = imagecolorallocate($new_image, 255, 255, 255);
				imagefill($new_image, 0, 0, $white);
				$source = imagecreatefromjpeg($path); 				
	        break;
	        case 'image/png':
			case 'image/x-png':				
				$source = imagecreatefrompng($path); 
				imagealphablending( $new_image, false );
				imagesavealpha( $new_image, true );
	        break;
	    }

	    imagecopyresampled($new_image, $source, 0, 0, $x, $y, $new_width, $new_height, $width, $height);
	    
	    switch ($image_type) {
	        case 'image/gif':
	            imagegif($new_image, $path);
	        break;
	        case 'image/pjpeg':
	        case 'image/jpeg':
	        case 'image/jpg':
	            imagejpeg($new_image, $path, 90); 
	        break;
	        case 'image/png':
			case 'image/x-png':
				/*imagesavealpha($new_image, true);
				$color = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
				imagefill($new_image, 0, 0, $color);*/
	            imagepng($new_image, $path);
	        break;
	    }

	    chmod($path, 0777);
	    return $path;
	}

	// Checks the min/max width/hight of the image
	private function check_image_size($path, $type) {
		$config = $this->config("types/$type");

		$min_width   = @$config['min_width'];
		$min_height  = @$config['min_height'];
		$max_width   = @$config['max_width'];
		$max_height  = @$config['max_height'];
		$min_width   = (empty($min_width)) ? 1 : $min_width;
		$min_height  = (empty($min_height)) ? 1 : $min_height;
		
		$size = @getimagesize($path);
		if ($size[0] < $min_width) {
			@unlink($path);
			$this->json_error( $this->error('min_width').$min_width.'px' );
		}
		if ($size[1] < $min_height) {
			@unlink($path);
			$this->json_error( $this->error('min_height').$min_height.'px' );
		}
		if ($max_width && $size[0] > $max_width) {
			@unlink($path);
			$this->json_error( $this->error('max_width').$max_width.'px' );
		}
		if ($max_height && $size[1] > $max_height) {
			@unlink($path);
			$this->json_error( $this->error('max_height').$max_height.'px' );
		}
	}


	private function get_full_url() {
	    $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
	    return
	        ($https ? 'https://' : 'http://').
	        (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
	        (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
	        ($https && $_SERVER['SERVER_PORT'] === 443 ||
	        $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
	        substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}

	private function json_success($data = array()) {
		//header('Content-Type: application/json');
	    echo json_encode(array('success' => true, 'data' => $data));
	   // exit;
	}

	private function json_error($data = array()) {
		//header('Content-Type: application/json');
	    echo json_encode(array('success' => false, 'data' => $data));
	    exit;
	}

	private function error($error) {
		if (isset($this->config['error_messages'][$error])) {
			return $this->config['error_messages'][$error];
		}
		return $error;
	}

	private function config($path) {
		$config = $this->config;
		$path = explode('/', $path);
		foreach ($path as $bit) {
			if (isset($config[$bit])) {
				$config = $config[$bit];
			} else $config = null;
		}
		return $config;
	}

	private function get_file_size($file_path, $clear_stat_cache = false) {
	    if ($clear_stat_cache) {
	        @clearstatcache(true, $file_path);
	    }
	    return fix_integer_overflow(filesize($file_path));
	}

	private function get_config_bytes($val) {
	    $val = trim($val);
	    $last = strtolower($val[strlen($val)-1]);
	    switch($last) {
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	    return $this->fix_integer_overflow($val);
	}

	private function fix_integer_overflow($size) {
	    if ($size < 0) {
	        $size += 2.0 * (PHP_INT_MAX + 1);
	    }
	    return $size;
	}
    function get_filename($object_id, $type) {
        // Generate filename based on object_id and type
        $time = time();
        //return $time . (empty($type) ? '' : "-$type"); 
        return $object_id.$time . (empty($type) ? '' : "-$type");
    }
    
    public function upload_image() {
        $this->save_cropped($this->request->getPost());
    }
}