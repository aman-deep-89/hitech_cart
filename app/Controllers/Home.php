<?php
namespace App\Controllers;
use App\Models\StoreModel;
use App\Models\DashboardModel;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Session\Session;
use DateTime;
class Home extends BaseController
{
	protected $data;
	protected $store_name;
	public function __construct() {
		parent::__construct();
		/*setcookie('cart','',time()-3600,'/');
		$cart=$_COOKIE['cart'];		
		echo $cart.'<br/>';; exit;
		print_r(json_decode($car,true));
		echo '<br/>';
		echo 'cart='.$_COOKIE['cart'].'<br/>';
		//$car2='['.$cart.']';
		//echo $car2; //exit;	
		//echo strcmp($car,$cart);
		print_r(json_decode($_COOKIE['cart'],true));
		exit;*/
		$this->store_name=get_cookie('store_name','/');
		$total_quantity=$total_price=0;	
		$this->data=array('total_qty'=>0,'total_price'=>0);
		/*if($cart) {
			$cart2=json_decode($_COOKIE['cart'],true);			
			/*var_dump($cart2);
			print_r($cart2); exit;*/
			/*if($cart2 && sizeof($cart2)) {
				foreach($cart2 as $v) {	
					//print_r($v); exit;			
					$total_quantity+=$v['quantity'];
					$total_price+=($v['quantity']*$v['price']);
				}
			}
			$this->data['total_qty']=$total_quantity;
			$this->data['total_price']=$total_price;
		}*/
		//print_r($this->data); exit;
	}
	public function index($ref='')
	{
		helper('form');
		$name=$ref;	
		//print_r($_COOKIE); exit;	
		/*if(empty($name)) 
			$this->store_name=get_cookie('store_name','/');
		/*if(empty($name))
			setcookie("store_name", $ref, time()+3600,'/');
		else setcookie("store_name", $name, time()+3600,'/');*/
		//$_COOKIE['store_name']=$name;
		//setcookie('store_name','kehkhe',time()-3600,'/');
		$store=new StoreModel();
		if($name=='')
			$name=$this->store_name;
		//print_r($_COOKIE);		
		$this->data['list']=$store->getProductList($name);
		//print_r($this->data);
		//exit;
		if($this->data['list'])	{
			return parent::_render('home',$this->data,$name);
		}
		//return parent::_render('home',$this->data);
		else return parent::_render('not_found',array(),'');
	}
	public function stores($store_name='')
	{
		helper('form');
		//setcookie("store_name", $store_name, time()+3600,'/');
		$this->data=array();		
		return parent::_render('home',$this->data,$store_name);
	}
	public function update_cart() {			
		/*setcookie('arjun_home_set','hello',time()+3600,'/');
			echo 'co=';
		   echo get_cookie('arjun_home_set');
			//exit;
		   // delete cookie
		   setcookie('arjun_home_set','',time()-3600,'/');
		   echo 'delete='.get_cookie('arjun_home_set');
		   exit;*/
		$item_id=$this->request->getPost('item_id');
		$quantity=$this->request->getPost('quantity');
		$store_name=get_cookie('store_name','/');
		$store=new StoreModel();
		$price=0;
		$item_detail=$store->getItemDetail($store_name,$item_id);
		if($item_detail) $price=$item_detail->sale_price;
		//setcookie('cart','',time()-3600);
		/*set_cookie('cart','',time()-3600);
		delete_cookie('cart');
		unset($_COOKIE['cart']);
		//print_r($_COOKIE);*/
		$cart=get_cookie('cart','/');
		//echo $_COOKIE['cart'].'ee';
		//echo 'c='.$cart; exit;
		$total_quantity=$total_price=0;
		$resp=array();
		//echo $cart; exit;		
		if(empty($cart) && $quantity>0) {
			$cart=array();
			$cart[$item_id]=array('item_id'=>$item_id,'quantity'=>$quantity,'price'=>$price);
			setcookie('cart',json_encode($cart),time()+3600,'/');	
			//echo 'cart set to '.json_encode($cart);
			$total_quantity=$quantity;		
			$resp=array('qty'=>$total_quantity,'price'=>($quantity*$price));
		} else {
			$cart=json_decode($_COOKIE['cart'],true);
			//print_r($cart);exit;
			if($quantity==0 && isset($cart[$item_id]))
				unset($cart[$item_id]);
			else if(isset($cart[$item_id])) {
				$qty=$cart[$item_id]['quantity'];
				if($quantity>5) {
					$resp['error']='You can\'t add more than 5';
					echo json_encode($resp);exit;
				}
				$cart[$item_id]=array('item_id'=>$item_id,'quantity'=>$quantity+1,'price'=>$price);				
			}
			else $cart[$item_id]=array('item_id'=>$item_id,'quantity'=>$quantity,'price'=>$price);			
			//print_r($cart); echo json_encode($cart); //exit;			
			//$_COOKIE['cart']=json_encode($cart);
			//echo 'c='.get_cookie('cart'); exit;
			//print_r($cart);
			foreach($cart as $key=>$v) {
				if($v['quantity']==0) unset($cart[$key]);
				else {
					$total_quantity+=$v['quantity'];
					$total_price+=($v['quantity']*$v['price']);
				}
			}
			//print_r($cart); exit;
			$c2=$cart;
			setcookie('cart',json_encode($c2),time()+3600,'/');
			$resp=array('qty'=>$total_quantity,'price'=>($total_price));

		}
		$resp['success']=true;
		echo json_encode($resp);
		exit;
	}
	public function get_products() {
		$last_id=$this->request->getPost('last_id');
		$store_name=$this->request->getPost('store_name');
		$store=new StoreModel();
		$item_detail=$store->getProductList($store_name,$last_id);
		$resp=array();
		if($item_detail) {
			$resp['success']=true;
			$resp['products']=array();
			foreach($item_detail as $id) {
				$resp['products'][]=$id;
			}
		} else $resp['error']='No more products to display';
		echo json_encode($resp);
		exit;
	}
	public function success() {
		if(logged_in()) 
			return redirect()->to('User/forecast_list');
		else 
			return parent::_render('success',array());
	}
	public function cart($store_name) {
		/*if($c) {
		//$cart=json_decode($_COOKIE['cart'],true);
		//$pd_ids=array_keys($cart);
		$store=new StoreModel();
		$this->data['cart']=$cart;
		$this->data['products']=$store->getProducts($pd_ids,$this->store_name);
		}*/
		//print_r($this->data); exit;
		return parent::_render('cart',$this->data,$store_name);		
	}
	public function place_order($store_name) {
		$this->data['cart']=null;
		$this->data['products']=null;
		/*$c=isset($_COOKIE['cart']) ? $_COOKIE['cart'] : null;
		if($c) {
			$cart=json_decode($_COOKIE['cart'],true);
			$pd_ids=array_keys($cart);
			$store=new StoreModel();
			$this->data['cart']=$cart;
			$this->data['products']=$store->getProducts($pd_ids,$this->store_name);
		}*/
		if(logged_in()) {
			$dashboard=new DashboardModel();		
			$this->data['address']=$dashboard->getAddresses(user_id());
			return parent::_render('user/place_order',$this->data,$store_name);
		}		
		else return parent::_render('place_order',$this->data,$store_name);
	}
	public function remove_item() {
		$item_id=$this->request->getPost('item_id');
		$c=isset($_COOKIE['cart']) ? $_COOKIE['cart'] : null;
		$resp=array();
		if($c) {
			$total_quantity=$total_price=0;
			$cart=json_decode($_COOKIE['cart'],true);
			unset($cart[$item_id]);
			foreach($cart as $key=>$v) {
				$total_quantity+=$v['quantity'];
				$total_price+=($v['quantity']*$v['price']);				
			}
			//print_r($cart); exit;
			$c2=$cart;
			setcookie('cart',json_encode($c2),time()+3600,'/');
			$resp=array('qty'=>$total_quantity,'price'=>($total_price));
			$resp['success']=true;
		}
		echo json_encode($resp);
		exit;
	}
	public function update_quantity() {
		$item_id=$this->request->getPost('item_id');
		$quantity=$this->request->getPost('quantity');
		$c=isset($_COOKIE['cart']) ? $_COOKIE['cart'] : null;
		$resp=array();
		if($c) {
			$total_quantity=$total_price=0;
			$cart=json_decode($_COOKIE['cart'],true);
			$cart[$item_id]['quantity']=$quantity;
			foreach($cart as $key=>$v) {
				$total_quantity+=$v['quantity'];
				$total_price+=($v['quantity']*$v['price']);				
			}
			//print_r($cart); exit;
			$c2=$cart;
			setcookie('cart',json_encode($c2),time()+3600,'/');
			$resp=array('qty'=>$total_quantity,'price'=>($total_price));
			$resp['success']=true;
		}
		echo json_encode($resp);
		exit;
	}
	public function demo() {
		print_r($_COOKIE);
		$cart=get_cookie('cart','/');
		echo $cart; exit;
	}	
	public function product_detail($store_name,$product_id) {		
		if($product_id<1) $this->index();
		else {
			$store=new StoreModel();
			$this->data['product_detail']=$store->getItemDetail($store_name,$product_id);
			return parent::_render('product_detail',$this->data,$store_name);			
		}
	}
	public function check_store_name() {
		$store_name=$this->request->getPost('store_name');
		$store=new StoreModel();
		$flag=$store->getStoreConfig($store_name);
		$resp=array();
		if($flag) {
			//setcookie('store_name','',time()+3600,'/');
			$resp['success']=true;
		} else $resp['error']='No detail found';
		echo json_encode($resp);
		exit;
	}
	public function not_found() {
		return parent::_render('not_found',$this->data);
	}
	public function signin($store_name) {		
		return parent::_render('login',$this->data,$store_name);
	}
	public function save_order() {	
		$rules=['form_payment' => 'required'];
		if($this->request->getPost('form_payment')!=null)
		{
			if($this->request->getPost('form_payment')=='selfpickup')
				$rules=['form_payment' => 'required','name2'     => 'required','mobile2'    => 'required|min_length[10]|max_length[10]'];
			if($this->request->getPost('form_payment')=='delivery')
				$rules = [ 'form_payment' => 'required', 'email'    => 'required|valid_email', 'mobile'    => 'required|min_length[10]|max_length[10]', 'address'     => 'required', 'name'     => 'required', 'pin_code'     => 'required', 'city'     => 'required', 'gst_tin'     => 'required', 'cart_value'     => 'required', ];
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
					$data['order']=['store_id'=>$store_name,'session_id'=>session_id(),'invoice_no'=>$store_info['nextnum'],'order_date'=>date('Y-m-d H:i:s'),'customer_name'=>$this->request->getPost('name'),'contact_no'=>$this->request->getPost('mobile'),'order_notes'=>$this->request->getPost('order_notes'),'o_pin_code'=>$this->request->getPost('pin_code'),'o_city'=>$this->request->getPost('city'),'o_gst_tin'=>$this->request->getPost('gst_tin'),'o_address'=>$this->request->getPost('address'),'o_email'=>$this->request->getPost('email'),'total_quantity'=>$quantity,'grand_total'=>$grand_total,'delivery_type'=>$this->request->getPost('form_payment')];				
				} else if($this->request->getPost('form_payment')=='selfpickup') {
					$data['order']=['store_id'=>$store_name,'session_id'=>session_id(),'invoice_no'=>$store_info['nextnum'],'order_date'=>date('Y-m-d H:i:s'),'customer_name'=>$this->request->getPost('name2'),'contact_no'=>$this->request->getPost('mobile2'),'order_notes'=>$this->request->getPost('order_notes2'),'total_quantity'=>$quantity,'grand_total'=>$grand_total,'delivery_type'=>$this->request->getPost('form_payment')];
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
	function order_detail($store_name,$invoice_no) {
		$store=new StoreModel();
		$this->data['order_detail']=$store->getOrderDetail($store_name,$invoice_no);
		return parent::_render('order_detail',$this->data,$store_name);
	}
}