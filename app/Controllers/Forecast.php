<?php
namespace App\Controllers;

use App\Models\ForecastModel;
use App\Models\DashboardModel;
use App\Models\UserForecastModel;
class Forecast extends BaseController
{
	public function index()
	{
		helper('form');
        $forecast=new ForecastModel();
        $list=$forecast->getAll();
        return parent::_render('admin/forecast/index',array('list'=>$list));
	}	
	public function create()
	{		
		helper('form');
        return parent::_render('admin/forecast/create',array());
	}
	public function store() {
		if ($this->request->getMethod() == "post") {
			$forecast_cat=new ForecastModel();
			$fc_id=$this->request->getPost('fc_id');
			$start_month=$this->request->getPost('fc_start_month');
			if($start_month>=12) $start_month=null;
			$flag=$forecast_cat->save([
                'fc_name'	=>	$this->request->getPost('fc_name'),
                'fc_description'	=>	$this->request->getPost('fc_description'),
                'fc_start_month'	=>	$start_month,
                'fc_id'	=>	$fc_id,
                'fc_enable'	=>	1,
            ]);
			$resp=array();
			if($flag) {
				$cat_id=$fc_id;
				if($fc_id<1)
					$cat_id=$forecast_cat->insertId();
				$detail=$this->request->getPost('field_detail');
				$info=array();
                foreach($detail as $d) 
                    $info[]=array('fc_id'=>$cat_id,'ft_name'=>$d['name'],'ft_description'=>$d['description'],'ft_enable'=>$d['enable']);
				$forecast_cat->saveForecastType($info,$fc_id);
				$resp['success']=true;
				$resp['url']=site_url('forecast/');
			}else {
				$resp['errors']=$forecast_cat->errors();
			}
			echo json_encode($resp);			
			exit;
		}
	}
	public function edit($id)
	{		
		helper('form');
		$forecast=new ForecastModel();
        $list=$forecast->getAll($id);
        return parent::_render('admin/forecast/create',array('list'=>$list));
	}
	public function delete() {
		$id=$this->request->getPost('fc_id');
		if(empty($id)) {
            session()->setFlashdata("error", "Id is not defined");
        } else {
            $forecast=new ForecastModel();
            $forecast->delete(['fc_id'=>$id]);
			session()->setFlashdata("message", "Forecast deleted successfully");
        }
        return redirect()->to('Forecast/');
    }
	public function notifications() {
		$is_admin=$is_user=null;
		if(in_groups('Admin')) $is_admin=true;
		else if(in_groups('User')) $is_user=true;
		$dashboard=new DashboardModel();
		$data=$dashboard->getNotifications($is_admin,$is_user);
		return parent::_render('notifications',array('notifications'=>$data));
	}
	public function read_notification() {
		$id=$this->request->getPost('id');
		$uforecast=new UserForecastModel();
		$uforecast->update($id,['admin_notification_read'=>1]);
		$resp['success']=true;
		echo json_encode($resp);
		exit;
	}
}