<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use App\Models\DashboardModel;
use App\Models\StoreModel;

class SiteConfig extends BaseConfig
{
	public $name = "hitech";
	public $author = "Sanjay Jain";

	public function get_info(){
		return $this->name;
	}
	public function get_config($store_name) {
		/*$st_name=get_cookie('store_name','/');
		if(isset($st_name))
			$store_name=$st_name; 
		else {
			$name=isset($_GET['ref']) ? $_GET['ref'] : $this->name;
			$store_name=$name;
			setcookie("store_name", $name, time()+3600,'/');
		}*/
		$store=new StoreModel();
		return $store->getStoreConfig($store_name);	
	}
	public function adminLayout() {
		return 'layout.php';
	}
	public function homeLayout() {
		return 'home_layout.php';
	}
	public function stickyLayout() {
		return 'sticky_layout.php';
	}
	public function showNotifications($is_admin,$is_user) {
		$dashboard=new DashboardModel();
		$data=$dashboard->getNotifications($is_admin,$is_user);
		return $data;
	}	
	public function getImages() {
		$images=array('logo'=>'logo.jpg','profile_img'=>'logo.jpg','favicon'=>'logo.jpg');
		return $images;
	}	
}