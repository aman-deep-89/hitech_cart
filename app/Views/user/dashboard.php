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
                            <a href="<?= site_url('User') ?>" class="nav-link active">My Orders</a>
                            <a href="#" class="nav-link">My Wishlist</a>
                            <a href="<?= site_url('User/manage_address') ?>" class="nav-link">Manages Address</a>
                            <a href="#" class="nav-link">Profile Information</a>
                            <a href="<?= base_url().route_to('logout').'/'.$store_info->store_username ?>" class="nav-link">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex align-items-center">
                            <h5 class="mb-md-0">Showing All Orders</h5>
                            <div class="ms-auto">
                                <div class="d-flex align-items-center">
                                    <label for="" class="form-label me-3 mb-0 fw-500">Fliter:</label>
                                    <select class="form-select form-contol-sm" aria-label="Default select example">
                                        <option selected>--- Select Filter ---</option>
                                        <option value="1">This Month</option>
                                        <option value="2">Previous Month</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Order No</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Item Count</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php if(isset($data['orders'])) { 
                                       foreach($data['orders'] as $val) { ?>
                                        <tr>
                                        <th scope="row">Order #<?= $val['invoice_no'] ?></th>
                                        <td>₹ <?= $val['grand_total'] ?></td>
                                        <td><?= $val['total_items'] ?> Items</td>
                                        <td><?= $val['od_date'] ?></td>
                                        <td class="pointer" data-bs-toggle="modal" data-bs-target="#orderDetails"><i class="bi-circle-fill text-warning me-2"></i><?= $val['order_status'] ?></td>
                                    </tr>
                                    <?php
                                       }
                                   } else { ?>
                                    <tr><td colspan="5">No orders have been placed yet</td></tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="orderDetails" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <article class="card order-group">
                        <header class="card-header d-flex align-items-center">
                            <div class="me-auto">
                            <b>Order ID: 6123456789</b>
                            </div>
        
                            <button class="btn btn-sm btn-outline-success me-4 font-13">
                                <i class="bi-whatsapp me-2"></i>Send Whatsapp
                            </button>
                            <span>Date/Time: <strong class="text-dark d-block"> July 6, 2021 2:12 PM </strong></span>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 payment-block">
                                    <h6 class="text-muted">Payment</h6>
        
                                    <div class="font-15">Subtotal: ₹300.00</div>
                                    <div class="font-15">Shipping fee: ₹0.00</div>
                                    <div class="mt-2 fw-bold font-16">Total: ₹300.00 </div>
        
                                </div>
                                <div class="col-md-4 contact-block">
                                    <h6 class="text-muted">Contact</h6>
                                    <div class="font-15">
                                        <div class="font-16">Michael Jackson</div>
                                        <div><i class="bi-telephone-fill font-12 me-2"></i> +1234567890</div>
                                        <div><i class="bi-envelope-fill font-12 me-3"></i>somename@gmail.com</div>
                                    </div>
                                </div>
                                <div class="col-md-4 shipping-block">
                                    <h6 class="text-muted">Shipping address</h6>
                                    <p class="mb-2"> Home 123, Building name, Street abcd, MH, 485692 </p>
                                    <i class="fw-500">Self Pickup</i>
                                </div>
                            </div> <!-- row.// -->
                            <hr>
        
                            <div class="my-4 d-md-flex align-items-start justify-content-between">
                                <div class="d-flex align-items-start">
                                    <i class="bi-clipboard-check text-success font-30"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Order Confirmed</h6>
                                        <p class="mb-0 fw-500 text-muted">Yesterday, 10.51 AM</p>
                                        <button class="btn btn-sm btn-outline-danger mt-3">Close Order</button>
                                    </div>
                            
                                </div>
                                <div class="w-auto flex-fill mx-5 mt-4 border"></div>
                                <div class="d-flex align-items-center">
                                    <i class="bi-truck font-30"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-orange">Order Shipped</h6>
                                        <p class="mb-0 fw-500">Yesterday, 10.51 AM</p>
                                    </div>
                                </div>
                                <div class="w-auto flex-fill mx-5 mt-4 border "></div>
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi-check-circle font-30"></i>
                                    <div class="ms-3">
                                        <h6 class="mb-0">Order Delivered</h6>
                                        <p class="mb-0 fw-500">Yesterday, 10.51 AM</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <ul class="list-group list-group-flush font-16">
                                <li class="list-group-item d-flex align-items-center">
                                    <img src="https://bootstrap-ecommerce.com/bootstrap-ecommerce-html/images/items/1.jpg"
                                        alt="" srcset="" class="img-xs img-thumbnail">
                                    <div class="ms-3">
                                        1 x Some name of item goes here nice
                                    </div>
                                    <div class="ms-auto">₹100</div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <img src="https://bootstrap-ecommerce.com/bootstrap-ecommerce-html/images/items/3.jpg"
                                        alt="" srcset="" class="img-xs img-thumbnail">
                                    <div class="ms-3">
                                        1 x Product name goes here nice
                                    </div>
                                    <div class="ms-auto">₹100</div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <img src="https://bootstrap-ecommerce.com/bootstrap-ecommerce-html/images/items/2.jpg"
                                        alt="" srcset="" class="img-xs img-thumbnail">
                                    <div class="ms-3">
                                        1 x Some name of item goes here nice
                                    </div>
                                    <div class="ms-auto">₹100</div>
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="fw-500 text-uppercase">
                                        Total
                                    </div>
                                    <div class="ms-auto fw-bold">₹300</div>
                                </li>
                            </ul>
                        </div>
                    </article>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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