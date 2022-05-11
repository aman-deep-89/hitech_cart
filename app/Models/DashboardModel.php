<?php 
namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = '';
    protected $primaryKey = '';

    protected $returnType = 'object';
    protected $allowedFields = [
        
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
       
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    public function getStatistics($user_id=null) {
        $cond='';
        return;
    }
    public function getNotifications($is_admin,$is_user) {
        if($is_admin)
            $res=$this->db->table('user_forecast')->select('*,DATE_FORMAT(forecast_date,"%d-%m-%Y") AS f_date')->where('admin_notification_read',0)->get()->getResult();     
        else if($is_user)
            $res=$this->db->table('user_forecast')->select('*,DATE_FORMAT(forecast_date,"%d-%m-%Y") AS f_date')->where('user_notification_read',0)->get()->getResult();     
        return $res;
    }
    public function getSettings() {
        $data=$this->db->query('SELECT *FROM configuration')->getRow();
        return $data;
    }
    public function getOrders($user_id) {
        $res=$this->db->table('orders')->select('*,COUNT(order_detail_id) AS total_items,DATE_FORMAT(order_date,"%b %d %Y %h:%i %p") AS od_date')->where('user_id',$user_id)->join('order_detail','order_id')->groupBy('order_id')->get();        
        return $res->getResultArray();
    }
    public function getAddresses($user_id) {
        $res=$this->db->table('user_addresses')->where('user_id',$user_id)->get();        
        return $res->getResultArray();
    }
    public function saveAddress($data) {
        $this->db->table('user_addresses')->insert($data);
        return $this->db->insertID();
    }
    public function saveOrder($data,$store_id) {
        $this->db->table('orders')->insert($data['order']);
        $order_id=$this->db->insertID();
        $order_detail=array();
        $i=0;
        foreach($data['order_detail'] as $od) {
            $order_detail[$i]=$od;
            $order_detail[$i]['order_id']=$order_id;
            $i++;
        }
        $this->db->table('order_detail')->insertBatch($order_detail);
        $this->db->table('store_company')->where('store_id',$store_id)->set('next_invoice_number','next_invoice_number+1',FALSE)->update();
        return true;
    }
}