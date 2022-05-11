<?php

namespace App\Controllers;
use App\Models\DashboardModel;
use App\Models\StoreModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;
class User extends BaseController
{
	protected $data;
	public function __construct() {
		parent::__construct();
		helper('auth');		
		$this->data=array('total_qty'=>0,'total_price'=>0);
	}
	public function index()
	{
		helper('auth');
		$dashboard=new DashboardModel();		
		$this->data['orders']=$dashboard->getOrders(user_id());
		$this->data['address']=$dashboard->getAddresses(user_id());
		return parent::_render('user/dashboard',$this->data,user()->store_username);
	}
	public function settings() {
		helper('form');
		helper(['auth','settings']);
		$data=array();
		$users=new UserModel();
		$user=$users->find(user_id());
        $data['list']=$user;
		$data['form_fields']['password']=['type'  => 'text', 'name'  => 'password', 'id'    => 'password', 'placeholder' => 'Password', 'class' => 'form-control'];
		$data['form_fields']['confirm_password']=['type'  => 'text', 'name'  => 'confirm_password', 'id'    => 'confirm_password', 'placeholder' => 'Confirm Password', 'class' => 'form-control'];
		$data['form_fields']['profile_image']=['type'  => 'text', 'name'  => 'profile_image', 'id'    => 'profile_image', 'placeholder' => 'Date of Forecast', 'class' => 'form-control'];
		return parent::_render('settings',$data);
	}
	public function save_settings() {
		helper(['auth','settings']);
		$rules = [
			'password'     => 'required_with[confirm_password]|strong_password',
			'confirm_password' => 'required_with[password]|matches[password]',
		];
		if (! $this->validate($rules))
		{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
		$password=$this->request->getPost('password');
		$profile_image=$this->request->getPost('profile_img');
		$favicon=$this->request->getPost('favicon');
		$logo=$this->request->getPost('logo');
		$user=new UserModel();
		$id=user_id();
		if(!empty($password))
			$user->update($id,['password'=>Password::hash($password),'profile_img'=>$profile_image]);
		else $user->update($id,['profile_img'=>$profile_image]);
		if(get_settings()) {
			$user->updateConfig($logo,$favicon);
		}
		else $user->createConfig($logo,$favicon);
		return redirect()->to('user')->with('message', 'Configuration updated successfully');
	}
	public function activity_log() {
		$user=new UserModel();
        $data['list']=$user->getActivityLog(user_id());
		return parent::_render('activity_log',$data);
	}
	public function manage_address() {
		if($this->request->getMethod()=='post') {
			$dashboard=new DashboardModel();
			$data=['user_id'=>user_id(),'address_full_name'=>$this->request->getPost('full_name'),'a_phone_no'=>$this->request->getPost('phone_no'),'address_type'=>$this->request->getPost('address_type'),'pin_code'=>$this->request->getPost('pin_code'),'state'=>$this->request->getPost('state'),'city'=>$this->request->getPost('city'),'house_no'=>$this->request->getPost('house_no'),'road_name'=>$this->request->getPost('road_name')];
			$dashboard->saveAddress($data);
			echo json_encode(array('success'=>true));
			exit;
		} else {
			$dashboard=new DashboardModel();		
			$this->data['address']=$dashboard->getAddresses(user_id());
			return parent::_render('user/manage_address',$this->data,user()->store_username);		
		}
	}
	public function save_order() {
		$rules=['form_payment' => 'required'];
		if($this->request->getPost('form_payment')!=null)
		{
			if($this->request->getPost('form_payment')=='selfpickup')
				$rules=['form_payment' => 'required','name2'     => 'required','mobile2'    => 'required|min_length[10]|max_length[10]','cart_value'=>'required'];
			if($this->request->getPost('form_payment')=='delivery')
				$rules = [ 'form_payment' => 'required', 'delivery_address'    => 'required','cart_value'=>'required'];
		}

		if (! $this->validate($rules))
		{
			echo json_encode(array('errors'=>$this->validator->getErrors()),true);
			exit;
		} else {
			$dashboard=new DashboardModel();
			$cart=$this->request->getPost('cart_value');
			$cart_value=json_decode($cart,true);
			$data=array();
			$store_name='';
			$quantity=$grand_total=0;
			foreach($cart_value as $val) {
				$store_name=$val['store_id'];
				$data['order_detail'][]=array('item_id'=>$val['item_id'],'od_quantity'=>$val['quantity'],'od_cost'=>$val['price'],'od_total_cost'=>$val['quantity']*$val['price']);
				$quantity+=$val['quantity'];
				$grand_total+=($val['quantity']*$val['price']);
			}
			$store=new StoreModel();
			$store_info=$store->getNextInvoiceNumber($store_name);
			if($store_info['nextnum']>1) {	
				if($this->request->getPost('form_payment')=='delivery') {			
					$shipping_address=$store->getShippingAddress($this->request->getPost('delivery_address'),user_id());
					if($shipping_address) {
						$data['order']=['store_id'=>$store_name,'user_id'=>user_id(),'session_id'=>session_id(),'invoice_no'=>$store_info['nextnum'],'order_date'=>date('Y-m-d H:i:s'),'total_quantity'=>$quantity,'grand_total'=>$grand_total,'delivery_type'=>$this->request->getPost('form_payment'),'customer_name'=>$shipping_address->address_full_name,'contact_no'=>$shipping_address->a_phone_no,'o_pin_code'=>$shipping_address->pin_code,'o_city'=>$shipping_address->city,'o_address'=>$shipping_address->house_no.' '.$shipping_address->road_name.' '.$shipping_address->address.'('.$shipping_address->address_type.')','o_email'=>user()->email];				
					} else {
						$data['errors']=array('Shipping address not found');
						echo json_encode($data);
						exit;
					}
				} else if($this->request->getPost('form_payment')=='selfpickup') {
					$data['order']=['store_id'=>$store_name,'user_id'=>user_id(),'session_id'=>session_id(),'invoice_no'=>$store_info['nextnum'],'order_date'=>date('Y-m-d H:i:s'),'customer_name'=>$this->request->getPost('name2'),'contact_no'=>$this->request->getPost('mobile2'),'order_notes'=>$this->request->getPost('order_notes2'),'total_quantity'=>$quantity,'grand_total'=>$grand_total,'delivery_type'=>$this->request->getPost('form_payment')];
				}
				//print_r($data); exit;
				$dashboard->saveOrder($data,$store_info['store_id']);
				$data['returnUrl']=base_url($store_name.'/order_detail/'.$store_info['nextnum']);
				$data['success']=true;
			} else {
				$data['errors']='Invalid Invoice No';
			}
			echo json_encode($data);
			exit;
		}
	}
}