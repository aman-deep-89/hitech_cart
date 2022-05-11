<?= $this->extend(config('SiteConfig')->homeLayout()) ?>
<?= $this->section('main') ?>

<div class="container">
        <div class="mt-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start w-100">
                                <h4 class="mb-4 green-heading"><?= user()->full_name ?></h4>
                                <div class="ms-auto">                                   
                                </div>
                            </div>
                            <div id="errors" class="text-danger">--</div>
                            <form action="" id="checkout">
                                <div class="form-group form-selectgroup form-selectgroup-boxes row">
                                <input type="hidden" name="<?= csrf_token() ?>" value='<?= csrf_hash() ?>'>
                                    <label class="form-selectgroup-item col-md-6" id="delivery">
                                        <input type="radio" name="form_payment" value="delivery"
                                            class="form-selectgroup-input" checked="">
                                        <div class="form-selectgroup-label p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="form-selectgroup-check"></span>
                                                <h6 class="mb-0 ms-3">Delivery</h6>
                                            </div>
                                            <div class="font-16 text-muted">We will deliver to your home</div>
                                        </div>

                                    </label>                                    
                                    <label class="form-selectgroup-item col-md-6" id="pickup">
                                        <input type="radio" name="form_payment" value="selfpickup"
                                            class="form-selectgroup-input">
                                        <div class="form-selectgroup-label p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="form-selectgroup-check"></span>
                                                <h6 class="mb-0 ms-3">Self pickup</h6>
                                            </div>
                                            <div class="font-16 text-muted">Come to our office to somewhere</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="row delivery-section">
                                   
                                        <?php if(isset($data['address'])) { 
                                            foreach($data['address'] as $key=>$val) { ?>                                        
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="delivery_address"
                                                    id="delivery_address<?= $key ?>" <?php if($key==0) echo 'checked'; ?> value="<?= $val['address_id'] ?>">
                                                <label class="form-check-label" for="delivery_address<?= $key ?>">
                                                    <div class="d-flex">
                                                        <div class="me-5">
                                                            <h6><?= $val['address_full_name'] ?></h6>
                                                            <p><?= $val['house_no'].' '.$val['road_name'].' '.$val['city'].' '.$val['state'].' '.$val['pin_code'] ?></p>
                                                            <button class="btn btn-sm btn-warning fw-bold font-12">DELIVER
                                                                HERE</button>
                                                        </div>
                                                        <div class="ms-auto">
                                                            <a href="" class="font-15 fw-500">EDIT</a>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <hr>
                                    <?php } 
                                    } ?>
                                    <a href="<?= site_url('user/manage_address') ?>" class="fw-500"><i class="bi-plus me-2"></i>Add a new address</a>
                                    <hr/>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="order_notes" class="form-label">Order Notes</label>
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pickup-section">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="form-label">Order Notes</label>
                                            <textarea name="" cols="30" rows="8" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-normal">We will contact you to confirm your order and send payment
                                    instructions.</h6>
                                    <input type="hiden" name="cart_value" id="cart_val" value=""/>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" id="app">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4 blue-heading">Cart Summary</h5>                             
                            <dl class="dlist-align cart-summary" v-if="cart_value.length" v-for="(obj, key, index) in cart_value">
                                <dt>{{JSON.parse(obj.item_image).item_name}}</dt>
                                <dd class="text-end">₹ {{obj.price*obj.quantity}}</dd>
                            </dl>                           
                            <hr>
                            <dl class="dlist-align cart-summary">
                                <dt class="fw-bold">To pay</dt>
                                <dd class="fw-bold text-end">₹ {{total_price}}</dd>
                            </dl>
                        </div>
                    <a id="placeOrder" class="btn btn-sm btn-primary w-100" v-if="total_price>0" @click="save_form">
                        <b>Place Order</b> <br>
                        <small class="font-10">COD (Cash on Delivery)</small>
                    </a>
                    <div class="text-danger" v-else>Please add a value in cart</div>
                    <div class="mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="offers">
                            <label class="form-check-label" for="offers">Yes, send me latest
                                promos and
                                special offers.</label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="form-check-input" id="orders">
                            <label class="form-check-label" for="orders">Remember me for future
                                orders.</label>
                        </div>
                    </div>
                    <!-- <a class="order-btn" id="placeOrder">
                        <i class="bi-whatsapp font-30 me-2"></i>
                        <div>
                            <small class="font-10 d-block">COD (Cash on delivery)</small>
                            Place Order - Rs. 350
                        </div>
                    </a> -->
                </div>

            </div>
        </div>
    </div>
    <div class="loader" id="loaderDiv">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h6 class="mt-31 font-16 mt-3 text-warning">Loading...</h6>
        <h6 class="text-white fw-400 font-15">Please don't refreash or press back</h6>
    </div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript" src="<?= site_url('public/assets/js/vue-2.6.14.js') ?>"></script>
<script type="text/javascript">
$("#loaderDiv").hide();
        $(function () {
            $("#placeOrder").click(function () {                
                
            });
        });
        var app = new Vue({
        el: '#app',
        data() {
            return {
                cart_value : [],
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
                            self.total_price+=parseFloat(results.rows.item(i).quantity*results.rows.item(i).price);
                        } 
                        $('#cart_val').val(JSON.stringify(self.cart_value));                     
                        }, null);                           
                    });
                });
            });            
        },
        methods: {
            save_form() {
                $('#loaderDiv').show();
               var form_data=$('#checkout').serialize();
               $.ajax({
                url:'<?= base_url('User/save_order') ?>',
                data:form_data,
                type:'post',
                dataType:'json',
                beforeSend: function() {
                    $('#errors').html('');
                },
                success:function(res) {
                    $('#loaderDiv').hide();
                    if(res.success) window.location=res.returnUrl;
                    else {
                        $.each(res.errors,function(index,item) {
                            $('#errors').append(item+'<br/>');                            
                        });
                    }                    
                }
            });
        }
    }
    });    
</script>
<?= $this->endSection() ?>