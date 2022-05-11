<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('main') ?>
<div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-success text-white">
                                SN
                            </div>
                            <div class="ms-3">
                                <small>Hello,</small>
                                <h6 class="mb-0"><?= user()->full_name ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="nav flex-column home-nav nav-pills">
                            <a href="index.html" class="nav-link active">My Orders</a>
                            <a href="my-wishlist.html" class="nav-link">My Wishlist</a>
                            <a href="manage-address.html" class="nav-link">Manages Address</a>
                            <a href="profile-info.html" class="nav-link">Profile Information</a>
                            <a href="<?= base_url().route_to('logout').'/'.$store_info->store_username ?>" class="nav-link">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
            <div class="card">
                    <div class="card-body">
                        <h5 class="mb-0">Manage Addresses</h5>
                        <hr>
                        <div class="card address-card" data-bs-toggle="collapse" href="#addAddress">
                            <div class="card-body">
                                <h6 class="mb-0"><i class="bi-plus me-2"></i>Add New Address</h6>
                            </div>
                        </div>

                        <div class="card bg-light collapse" id="addAddress">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="" class="form-label">Full Name</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Type of address</label>
                                            <select class="form-control form-control-sm" aria-label="Type of address">
                                                <option selected>Home</option>
                                                <option value="1">Work</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Pincode</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">State</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">City</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">House No, Building Name</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class="form-label">Road Name, Area, Colony</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer d-flex">
                                <button class="ms-auto btn btn-sm btn-success">Save Address</button>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="badge bg-secondary lh-0">HOME</div>
                                    <div class="dropdown ms-auto pointer">
                                        <i class="bi-three-dots-vertical" id="optionMenu" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu" aria-labelledby="optionMenu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h6>Sanjay Naguat</h6>
                                <p class="mb-0">Block # 103, 1st floor, Balaji Sanyog Apartment, Besa Rd, opp. Petrol
                                    Pump, Besa, Nagpur, Maharashtra 440037</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="badge bg-secondary lh-0">HOME</div>
                                    <div class="dropdown ms-auto pointer">
                                        <i class="bi-three-dots-vertical" id="optionMenu" data-bs-toggle="dropdown"></i>
                                        <ul class="dropdown-menu" aria-labelledby="optionMenu">
                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <h6>Sanjay Naguat</h6>
                                <p class="mb-0">Block # 103, 1st floor, Balaji Sanyog Apartment, Besa Rd, opp. Petrol
                                    Pump, Besa, Nagpur, Maharashtra 440037</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript" src="<?= site_url('public/assets/js/vue-2.6.14.js') ?>"></script>
<script type="text/javascript">
/*var home_cart=getCookie('cart');
var store_name=getCookie('store_name');
let cart={};
//console.log(home_cart);
if(home_cart) {
    let store_cart=JSON.parse(home_cart);
    if(store_cart[store_name]!=null || store_cart[store_name]!=undefined)  {
        cart=store_cart[store_name];
    }
}
console.log("Cart=");
console.log(cart);*/
var csrfName = '<?= csrf_token() ?>';
var csrfHash = '<?= csrf_hash() ?>';  
//Vue.use(window.vuelidate.default)
//const { required, minLength } = window.validators
    var app = new Vue({
        el: '#app',
        data() {
            return {
                cart_value : [],
                [csrfName]: csrfHash, 
                submitStatus:null,
                total_price:0,
                total_qty:0,
                submitted:null,
                submitType:null
            }
        },
        validations: {            
        },
        mounted:function() {
            var self=this;
            var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
            var msg;
            db.transaction(function (tx) {  
                tx.executeSql('SELECT *FROM STORE',[],function(ts,data) {
                    store_name=data.rows.item(0).store_name;
                    db.transaction(function (tx) {   
                        tx.executeSql('SELECT * FROM CART  WHERE store_id=?', [store_name], function (tx, results) { 
                        var len = results.rows.length, i; 
                        for (i = 0; i < len; i++) { 
                            /*self.cart_value[i]=results.rows.item(i);
                            self.cart_value[i]['item_image']=JSON.parse(results.rows.item(i).item_image);*/
                            //self.cart_value.push(results.rows.item(i));
                            self.cart_value.push(results.rows.item(i));
                            /*self.total_qty=self.total_qty+parseInt(results.rows.item(i).quantity);
                            self.total_price=self.total_price+(parseFloat(results.rows.item(i).price)*parseInt(results.rows.item(i).quantity));*/
                        }        
                        self.update_cart();  
                        }, null);                        
                    });
                });
            });            
        },
        methods: {
            update_cart(item_id,evt) {
                console.log("cart");
                console.log(this.cart_value);
                // $.each(this.cart_value,function(index,item) {
                this.total_qty=0;
                this.total_price=0;
                Array.prototype.forEach.call(this.cart_value, item => {
                    this.total_qty+=parseInt(item.quantity);
                    this.total_price+=(parseInt(item.quantity)*parseFloat(item.price)); 
                    console.log("price"+item.price);
                });                                
                /*const keys = Object.keys(this.cart_value);
                console.log(keys);
                for (let i = 0; i < keys.length; i++) {
                    console.log(this.cart_value(keys));
                }*/
                if(evt) {  
                    var quantity=evt.target.value;                  
                    var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
                    var msg;
                    db.transaction(function (tx) {  
                        tx.executeSql('SELECT *FROM STORE',[],function(ts,data) {
                            store_name=data.rows.item(0).store_name;
                            db.transaction(function (tx) {   
                                tx.executeSql('UPDATE CART SET quantity=? WHERE store_id=? AND item_id="'+item_id+'"', [quantity,store_name], function (tx, results) {                                
                                }, null);                        
                            });
                        });
                    });  
                }
                $('#total_qty').text(this.total_qty);
                $('#total_price').text(this.total_price);
                $('#subtotal,#grand_total').text(this.total_price);
            },
            remove_item($evt,key,item_id) {
                $evt.preventDefault();
                let c=JSON.parse(JSON.stringify(this.cart_value));   
                let self=this; 
                console.log("k="+key);            
                delete c[key];
                this.cart_value=c.filter(e =>  e);;
                console.log(c);
                self.total_qty=0;
                self.total_price=0;
                console.log(self.cart_value);
                Array.prototype.forEach.call(self.cart_value, item => {
                    self.total_qty+=parseInt(item.quantity);
                    self.total_price+=(parseInt(item.quantity)*parseFloat(item.price)); 
                });
                var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
                var msg;
                db.transaction(function (tx) {  
                    tx.executeSql('SELECT *FROM STORE',[],function(ts,data) {
                        store_name=data.rows.item(0).store_name;
                        db.transaction(function (tx) {   
                            tx.executeSql('DELETE FROM CART  WHERE store_id=? AND item_id="'+item_id+'"', [store_name], function (tx, results) {                                
                            }, null);                        
                        });
                    });
                }); 
                $('#total_qty').text(self.total_qty);
                $('#total_price').text(self.total_price);
                $('#subtotal,#grand_total').text(self.total_price);     
            },
            processForm() {
                this.submitStatus='PENDING';
                this.submitted='PENDING';
                this.$v.$touch();
                if (this.$v.$invalid) {
                    console.log(this.$v.forecast_date);
                    console.log(this.submitType);
                    this.submitStatus=null;
                } else {
                    var form_data=this.$data;
                    var error_log=null;
                    this.submitStatus='SAVING';
                    $.ajax({                        
                        url : '<?php echo site_url('home/save_user_forecast'); ?>',
                        data:form_data,
                        type:'post',
                        dataType:'json',
                        async: false,
                        beforeSend:function() {
                            $('#loader').show();
                        },
                        success:function(res) {
                            $('#loader').show();
                            if(res.success)
                                window.location=res.url;
                            else if(res.login) {
                                $('#loginModal').modal('show');
                            } else {
                                error_log=res.errors;
                            }
                        }
                    });
                    this.submitStatus=null;
                    if(error_log) {
                        let error_list=[];
                        $.each(error_log, function(key,value) {                            
                            error_list.push(value);
                        });
                        this.errors.push(error_list);    
                        console.log(this.errors);
                    }
                    //this.$refs.form.submit()
               }
            }
        }
    });    
</script>
<?= $this->endSection() ?>