<?php

namespace App\Controllers;
use App\Models\DashboardModel;
use Mpdf\Mpdf;
use App\Models\ForecastModel;
use Myth\Auth\Models\UserModel;
use App\Models\UserForecastModel;

class Admin extends BaseController
{
	public function index()
	{
		$dashboard=new DashboardModel();
		$data['statistics']=$dashboard->getStatistics();
		return parent::_render('admin/dashboard',$data);
	}
	public function user_list()
	{
		$user=new UserModel();
		$data['user_list']=$user->findAll();
		return parent::_render('admin/user_list',$data);
	}
	public function download_pdf($id=0)
	{
		require APPPATH.'ThirdParty/vendor/autoload.php';
		$mpdf = new Mpdf();
		$forecast=new ForecastModel();
        $data['list']=$forecast->getList();
		$forecast_list=new UserForecastModel();		
		if(in_groups('Admin'))
			$data['user_list']=$forecast_list->where('uf_id',$id)->join('users','users.id=user_forecast.user_id','LEFT')->get()->getResultArray();
		else $data['user_list']=$forecast_list->where('uf_id',$id)->join('users','users.id=user_forecast.user_id','LEFT')->where('user_id',user_id())->get()->getResultArray();
		$html = file_get_contents(FCPATH.'public/css/report.css'); // render the view into HTML
		$mpdf->WriteHTML($html,1);
		$mpdf->useFixedNormalLineHeight = false;
		$mpdf->useFixedTextBaseline = false;
		$mpdf->normalLineheight = 2.33;
		$mpdf->DeflMargin=5;
		$mpdf->DefrMargin=5;
		$html = parent::_render('forecast_pdf',$data);
		$mpdf->WriteHTML($html);
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->Output('forecast_'.$id.'.pdf','D');
	}
	public function download_csv($id=0)
	{
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=forecast.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		$forecast=new ForecastModel();
        $list=$forecast->getList();
		$forecast_list=new UserForecastModel();		
		if(in_groups('Admin'))
			$user_list=$forecast_list->where('uf_id',$id)->join('users','users.id=user_forecast.user_id','LEFT')->get()->getResultArray();
		else $user_list=$forecast_list->where('uf_id',$id)->join('users','users.id=user_forecast.user_id','LEFT')->where('user_id',user_id())->get()->getResultArray();
		$customer_name=$forecast_date=$account_number=$user=null;		
		$i=0;
		$categories=$sub_categories=array();
		foreach($list as $l) {
			if($i==0) {
				$categories[$l->fc_id]=$l;
				$sub_categories[$l->ft_id]=$l->ft_name;
			}
		}
		$csv_detail=array();
		$month_names=array('January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December');
		array_push($csv_detail,array('ID','Cust_Name','Acount_Code','Sub_Date','User','Forcast_Type','Start_Date','Product','Month_1	','Month_2','Month_3','Month_4','Month_5','Month_6','Month_7','Month_8','Month_9','Month_10','Month_11','Month_12'));
		$i=1;		
		foreach($user_list as $ul) {
			$customer_name=$ul['distributor_name'];
			$forecast_date=$ul['forecast_date'];
			$account_number=$ul['account_number'];			
			$forecast_detail=json_decode($ul['forecast_data'],true);
			//print_r($forecast_detail); exit;
			foreach($forecast_detail as $fc_id=>$ft) {
				$cat_name='-';
				$start_month='-';
				if(isset($categories[$fc_id])) {
					$cat_name=$categories[$fc_id]->fc_name;
					$start_month=$categories[$fc_id]->fc_start_month!=null && $categories[$fc_id]->fc_start_month<12 ? $month_names[$categories[$fc_id]->fc_start_month] : date('M');
 				} 
				foreach($ft as $ft_id=>$ft_detail) {
					$product_name=isset($sub_categories[$ft_id]) ? $sub_categories[$ft_id] : '-';
					$csv_detail[$i]=array($ul['uf_id'].'-'.$ft_id,$customer_name,$account_number,$forecast_date,$ul['username'],$cat_name,$start_month,$product_name);
					foreach($ft_detail as $key=>$fd) {
						$csv_detail[$i][$key]=$fd;
					}
					$i++;
				}
			}
		}
		$fp = fopen('php://output', 'w');
		foreach ($csv_detail as $fields) {
			fputcsv($fp, $fields);
		}
		fclose($fp);
		exit;
	}
}
