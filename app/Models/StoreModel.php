<?php 
namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table = 'store_register';
    protected $primaryKey = 'store_id';

    protected $returnType = 'object';
    protected $allowedFields = [
        'store_id', 'banner','logo','store_username'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    public function getStoreConfig($name) {
        $res=$this->db->table('store_company')->join('store_register','store_register.store_id=store_company.store_id')->join('store_seo_media','store_seo_media.store_id=store_register.store_id')->where('store_username',$name)->get();        
        //echo $this->db->getLastQuery(); exit;
        if($res->getNumRows()) { return $res->getRow(); }
        else return false;
    }
    public function getProductList($store_name,$last_id=0) {
        $res=$this->db->table('store_item_register')->join('store_register','store_register.store_id=store_item_register.store_id')->where('store_username',$store_name)->where('enabled',1)->where('deleted',0)->where('item_id>',$last_id)->orderBy('item_id','DESC')->limit(5)->get();
        //echo $this->db->getLastQuery(); exit;
        if($res->getNumRows()) { return $res->getResultArray(); }
        else return false;
    }
    public function getItemDetail($store_name,$item_id) {
        $res=$this->db->table('store_item_register')->join('store_register','store_register.store_id=store_item_register.store_id')->where('store_username',$store_name)->where('enabled',1)->where('deleted',0)->where('item_id',$item_id)->limit(1)->get();
        if($res->getNumRows()) { return $res->getRow(); }
        else return false;
    }
    public function getProducts($pd_ids,$store_name) {
        $res=$this->db->table('store_item_register')->join('store_register','store_register.store_id=store_item_register.store_id')->where('store_username',$store_name)->where('enabled',1)->where('deleted',0)->whereIn('item_id',$pd_ids)->get();
        //echo $this->db->getLastQuery();
        if($res->getNumRows()) { return $res->getResultArray(); }
        else return false;
    }
    public function getNextInvoiceNumber($store_name) {
        $res=$this->db->table('store_company')->join('store_register','store_register.store_id=store_company.store_id')->where('store_username',$store_name)->get();
        //echo $this->db->getLastQuery();
        $data=['next_invoice_num'=>-1,'store_id'=>0];
        if($res->getNumRows()) {
            $row=$res->getRow();
            $data['nextnum']=$row->invoice_no_start+$row->next_invoice_number;
            $data['store_id']=$row->store_id;
        }
        return $data;
    }
    public function getOrderDetail($store_name,$invoice_no) {
        $res=$this->db->table('orders')->select('*,DATE_FORMAT(order_date,"%b %d %Y %h:%i %p") AS od_date')->where('orders.store_id',$store_name)->where('invoice_no',$invoice_no)->join('order_detail','orders.order_id=order_detail.order_id')->join('store_item_register','store_item_register.item_id=order_detail.item_id')->get();
        if($res->getNumRows()) return $res->getResultArray();
        else return false;
    }
    public function getShippingAddress($address_id,$user_id) {
        $res=$this->db->table('user_addresses')->where('address_id',$address_id)->where('user_id',$user_id)->get();
        if($res->getNumRows()) {
            return $res->getRow();
        }
        else return false;
    }
}