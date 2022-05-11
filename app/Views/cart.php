<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('main') ?>
<div class="section-content padding-y">
<div class="container">
<div>
                                <a href="<?= site_url('Home') ?>" class="btn btn-sm cart-remove btn-light"> <i
                                        class="bi-chevron-left"></i> Continue shopping </a>
                            </div>  
<div class="row">
                <main class="col-md-9">
                    <div class="card" id="app">
                        <div class="table-responsive">
                            <div id="error" class="text-danger"></div>
                            <div id="status"><div>
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th>Product</th>
                                        <th width="120">Quantity</th>
                                        <th width="120">Price</th>
                                        <th class="text-end" width="200"> </th>
                                    </tr>
                                </thead>
                                <tbody>                                    
                                        <tr id="row" v-for="(obj, key, index) in cart_value">
                                            <td>
                                                <figure class="itemside">
                                                    <div class="aside">
                                                        <img :src="JSON.parse(obj.item_image).item_image" class="img-sm img-thumbnail"></div>
                                                    <figcaption class="info ms-3">
                                                        <h6 class="mb-1">{{JSON.parse(obj.item_image).item_name}}</h6>
                                                        <p class="text-muted small">{{JSON.parse(obj.item_image).description}}</p>
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td>
                                                <select class="form-select item_quantity" :data-id="obj.item_id" v-model="obj.quantity" @change="update_cart(obj.item_id,$event)">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price">₹ {{obj.price*obj.quantity}}</var>
                                                    <small class="text-muted text-decoration-line-through"> ₹ {{JSON.parse(obj.item_image).mrp*obj.quantity}}
                                                    </small>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-light cart-remove remove_item" @click="remove_item($event,key,obj.item_id) "> <i class="bi-trash-fill text-danger"></i> Remove</a>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>                           
                        </div>                       
                    </div>

                    <div class="alert alert-success offer-alert mt-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi-tags-fill me-3 font-20 text-success"></i>
                            <div>Extra Upto <b>23% Off</b> on <b>Rs. 2490 </b> and above.</div>
                        </div>
                    </div>

                </main>
                <aside class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label">Have coupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Coupon code"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <a href="" class="text-decoration-none input-group-text btn-primary"
                                            id="basic-addon2">Apply</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Subtotal</dt>
                                <dd class="text-end">₹ <span id="subtotal"></span></dd>
                            </dl>
                            <dl class="dlist-align text-danger">
                                <dt>Discount:</dt>
                                <dd class="text-end">- ₹ 00.00</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>GST:</dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Delivery Charges <i class="bi-info-circle lh-1 ms-2 pointer"></i></dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align">
                                <dt class="text-uppercase text-muted"> <strong> Total </strong></dt>
                                <dd class="text-end h6"><strong>₹ <span id="grand_total"></span></strong></dd>
                            </dl>
                            <a href="<?= site_url($store_info->store_username.'/place_order') ?>" class="btn btn-primary mt-3 d-block"><i
                                    class="bi-bag-check me-2"></i> Proceed to checkout</a>
                        </div>
                    </div>
                </aside>
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