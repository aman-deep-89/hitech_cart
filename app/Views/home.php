<?= $this->extend(config('SiteConfig')->homeLayout()) ?>
<?= $this->section('main') ?>
<div class="container">
        <div class="row align-items-end align-items-md-center my-3">
            <div class="col-6 col-md-3 d-md-flex align-items-center m-mb-2">
                <label for="" class="mb-0 me-2">Sort By</label>
                <div class="flex-fill">
                    <select class="form-select" aria-label="Default select example">
                        <option selected>Price: Lowest First</option>
                        <option value="1">Price: Highest First</option>
                    </select>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="input-group m-mb-2">
                    <input type="text" class="form-control rounded-0" placeholder="Search our best products"
                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="dropdown">
                        <span
                            class="border-start-0 text-muted input-group-text dropdown-toggle rounded-0 pointer bg-white"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">All</span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-10 col-md-3">
                <h6 class="mb-0">All Apps <span class="small text-muted">(Showing 1-40 products of
                        96,562)</span></h6>
            </div>
            <div class="col-2 col-md-2">
                <div class="d-flex">
                    <div class="ms-auto">
                        <div class="btn-group" role="group" aria-label="First group">
                            <button type="button" class="btn btn-sm btn-outline-secondary lh-1" onclick="toggle(this)">
                                <i class="bi-grid-3x3-gap-fill" id="icon"></i></button>
                            <!-- <button type="button" class="btn btn-sm active btn-outline-secondary"><i
                                        class="bi-list-ul"></i></button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="list">
            <div class="d-flex flex-wrap product-grid">
                <?php 
                $last_id=0;
                if(isset($data['list']) && is_array($data['list'])) {
                    $last_id=$data['list'][0]['item_id'];
                    foreach($data['list'] as $product) { ?>
                <div class="card product-card">
                    <a href="<?= site_url($store_info->store_username.'/products/'.$product['item_id']) ?>">
                        <img src="<?= site_url('public/uploads/'.$product['item_image']); ?>" class="product-img" alt="<?= $product['item_name']; ?>">
                    </a>
                    <?php if($product['hot_deal']>0) { ?>
                        <span class="badge rounded-pill bg-success text-uppercase ms-auto lh-sm offer-tag"><?php echo $product['hot_deal']; ?>% OFF</span>
                    <?php } ?>
                    <div class="card-body">
                        <?php
                            $product['item_image']=site_url('public/uploads/'.$product['item_image']);
                        ?>
                        <input type="hidden" id="product<?= $product['item_id'] ?>" value='<?php echo json_encode($product) ?>'/>
                        <h6 class="mb-1 "><?= $product['item_name']; ?></h6>
                        <div class="small text-muted">Product Code <b><?= $product['item_code'] ?></b></div>
                        <div class="d-flex align-items-center mt-2">
                            <div>
                                <h6 class="fw-700 mb-0">₹ <?= $product['sale_price'] ?></h6>
                                <span class="text-muted text-decoration-line-through">₹<?= $product['mrp'] ?></span>
                            </div>
                            <div class="ms-auto">
                                <?php if($product['out_of_stock']==0) { ?>
                                <a href="javascript:void(0)" class="count-input">
                                    <span class="decreamentbtn" data-product_id="<?= $product['item_id']; ?>">
                                        <i class="bi-dash-lg font-10"></i>
                                    </span>                                    
                                    <input type="text" class="text-center count-class" value="0" id="count<?= $product['item_id']; ?>">
                                    <span class="increamentbtn" data-product_id="<?= $product['item_id']; ?>">
                                        <i class="bi-plus-lg font-10"></i>
                                    </span>
                                </a>
                                <a href="javascript:void(0)" class="cart-btn">
                                    <i class="bi-cart font-14 lh-1 me-1"></i>Add
                                </a>
                                <?php } else { ?>
                                    <button class="btn btn-sm btn-outline-danger font-11 fw-500">Out of Stock</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } else echo '<div id="no_product">No product is available in this store</div>';
                ?>
            </div>
            <div id="empty" class="text-center mt-2 btn btn-default d-block"></div>                
        </div>        
        <input type="hidden" id="csrfTokenName" value="<?= csrf_token() ?>" />
        <input type="hidden" id="csrfTokenValue" value="<?= csrf_hash() ?>" />
        <div class="product-list mt-5" id="grid">
            <div class="table-responsive" id="product_detail">
            <table class="table">
                 <tbody>
            <?php if(isset($data['list']) && is_array($data['list'])) {
                    foreach($data['list'] as $product) { ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="list-avatar">
                                        <img src="https://www.hustlemotivation.in/corona/blogs/images/off-billing.png"
                                            alt="">
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1 "><?php echo $product['item_name']; ?></h6>
                                        <div class="small text-muted">Product Code <b><?php echo $product['item_code']; ?></b></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <h6 class="fw-700 mb-0">₹ <?php echo $product['sale_price']; ?></h6>
                                    <span class="text-muted ms-3 text-decoration-line-through">₹<?php echo $product['mrp']; ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if($product['out_of_stock']==0) { ?>
                                <div class="input-group count-input ms-auto">
                                    <span class="input-group-text" onclick="plus()">+</span>
                                    <input type="number" class="form-control form-control-sm text-center" value="0"
                                        id="count">
                                    <span class="input-group-text" onclick="minus()">-</span>
                                </div>
                                <?php } ?>
                            </td>
                            <td>
                            <?php if($product['out_of_stock']==0) { ?>
                                <a href="javascript:void(0)" class="cart-btn-table">
                                    <i class="bi-cart font-14 lh-1 me-1"></i>Add
                                </a>
                            <?php } else  { ?>
                                <button class="btn btn-sm btn-outline-danger font-11 fw-500">Out of Stock</button>      
                            <?php } ?>
                            </td>
                        </tr>                       
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
$(function() {        
            var last_id=<?php echo $last_id; ?>;
            var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
            var store_name='';
            db.transaction(function (tx) {  
                tx.executeSql('SELECT *FROM STORE',[],function(ts,data) {
                    store_name=data.rows.item(0).store_name;
                });
            });
            var empty=false;
            $(window).bind('scroll', function() {                
               // var total_top=$('#list').offset().top + $('#list').outerHeight() - window.innerHeight;
                //if($(window).scrollTop() >= total_top && $(window).scrollTop()<=total_top+2) {
               // if($(window).scrollTop() == $(document).height() - $(window).height()) {
                var position = parseInt($(window).scrollTop());
                var bottom = $(document).height() - $(window).height();
                //console.log(position+'='+bottom);
                if( position == bottom-1 && !empty ){
                    var f_data={};
                    f_data['last_id']=last_id;
                    f_data['store_name']=store_name;
                    f_data['<?= csrf_token() ?>']='<?= csrf_hash() ?>';
                   $.ajax({
                    url:'<?php echo site_url('Home/get_products'); ?>',
                    data:f_data,
                    type:'POST',
                    dataType:'json',
                    success:function(res) {
                        if(res.success) {
                            $('#no_product').hide();
                            last_id=last_id+5;
                            var str='',str2='';
                            $.each(res.products,function(index,item) {
                                str+='<div class="card product-card">\
                    <a href="<?= base_url($store_info->store_username.'/products/') ?>'+item.item_id+'">\
                        <img src="<?= site_url('public/uploads/') ?>'+item.item_image+'"\ class="product-img" alt="...">\
                    </a>';                    
                    if(item.hot_deal>0) { 
                        str+='<span class="badge rounded-pill bg-success text-uppercase ms-auto lh-sm offer-tag">'+item.hot_deal+'% OFF</span>';
                    }
                    str+='<div class="card-body">\
                        <h6 class="mb-1 ">'+item.item_name+'</h6>\
                        <div class="small text-muted">Product Code <b>'+item.item_code+'</b></div>\
                        <div class="d-flex align-items-center mt-2">\
                            <div>\
                                <h6 class="fw-700 mb-0">₹ '+item.sale_price+'</h6>\
                                <span class="text-muted text-decoration-line-through">₹'+item.mrp+'</span>\
                            </div>\
                            <div class="ms-auto">';
                                if(item.out_of_stock==0) { 
                                str+='<a href="javascript:void(0)" class="count-input" style="display:none">\
                                    <span class="increamentbtn" data-product_id="'+item.item_id+'">\
                                        <i class="bi-plus-lg font-10"></i>\
                                    </span>\
                                    <input type="text" class="text-center count-class" value="0" id="count">\
                                    <span class="decreamentbtn" data-product_id="'+item.item_id+'">\
                                        <i class="bi-dash-lg font-10"></i>\
                                    </span>\
                                </a>\
                                <a href="javascript:void(0)" class="cart-btn">\
                                    <i class="bi-cart font-14 lh-1 me-1"></i>Add\
                                </a>';
                                } else {
                                    str+='<button class="btn btn-sm btn-outline-danger font-11 fw-500">Out of Stock</button>';
                                }
                            str+='</div>\
                        </div>\
                    </div>\
                </div>';
                str2+='<tr>\
                            <td>\
                                <div class="d-flex align-items-center">\
                                    <div class="list-avatar">\
                                    <a href="<?= base_url($store_info->store_username.'/products/') ?>'+item.item_id+'">\
                                        <img src="<?= site_url('public/uploads/') ?>'+item.item_image+'" alt="">\
                                        </a>\
                                    </div>\
                                    <div class="ms-3">\
                                        <h6 class="mb-1 ">'+item.item_name+'</h6>\
                                        <div class="small text-muted">Product Code <b>'+item.item_code+'</b></div>\
                                    </div>\
                                </div>\
                            </td>\
                            <td>\
                                <div class="d-flex">\
                                    <h6 class="fw-700 mb-0">₹ '+item.sale_price+'</h6>\
                                    <span class="text-muted ms-3 text-decoration-line-through">₹'+item.mrp+'</span>\
                                </div>\
                            </td>\
                            <td>';
                            if(item.out_of_stock==0) { 
                                str2+='<div class="input-group count-input ms-auto">\
                                    <span class="input-group-text increamentbtn" data-product_id="'+item.item_id+'">+</span>\
                                    <input type="number" class="form-control form-control-sm text-center" value="0"\
                                        id="count">\
                                    <span class="input-group-text decreamentbtn" data-product_id="'+item.item_id+'">-</span>\
                                </div>';
                            }
                            str2+=' </td> <td>';
                            if(item.out_of_stock==0) {
                                str2+='<a href="javascript:void(0)" class="cart-btn-table">\
                                    <i class="bi-cart font-14 lh-1 me-1"></i>Add\
                                </a>';
                            }
                            else  {
                                str2+='<button class="btn btn-sm btn-outline-danger font-11 fw-500">Out of Stock</button>';
                                str2+='</td></tr>';
                            } 
                        });                           
                            $('#list .product-grid').append(str);                            
                            $('#product_detail .table tbody').append(str2);                                                    
                        } else {
                            $('#empty').html(res.error);
                            empty=true;
                        }
                    }
                   });
                }
            });        
            $("html, body").animate({scrollTop: $(document).height()-$(window).height()});
});
</script>
<?= $this->endSection() ?>