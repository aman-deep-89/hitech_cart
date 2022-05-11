<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('main') ?>
<div class="container">
<div class="mt-4">
            <div class="d-flex mb-5 align-items-center flex-wrap cart-parent">
                <div>
                    <a href="<?= site_url('/') ?>" class="btn btn-sm btn-outline-primary px-4">Home</a>
                </div>
                <div class="ms-3">
                    <a href="<?= site_url('/') ?>" class="btn btn-sm cart-remove btn-light"> <i class="bi-chevron-left"></i>
                        Continue shopping </a>
                </div>
            </div>
            <div class="row">
                <?php if(isset($data['product_detail'])) { 
                    $val=$data['product_detail'];
                    ?>
                <div class="col-md-4">
                    <div class="product-img-block position-relative">
                        <img id="myimage"
                            src="<?= site_url('public/uploads/'.$val->item_image); ?>">
                        <div id="myresult" class="img-zoom-result"></div>
                    </div>
                </div>
                <div class="col-md-8" id="product_detail">
                    <h4 class="text-capitalize fw-bold">
                        <?= $val->item_name ?>
                        <span class="ms-2 fw-normal text-muted font-18"></span>
                    </h4>
                    <div class="d-flex align-items-center mt-3">
                        <h4>₹ <?= $val->sale_price ?></h4>
                        <span class="text-muted ms-3 text-decoration-line-through">₹ <?= $val->mrp ?></span>
                        <span class="text-success fw-500 ms-3">₹ <?= $val->mrp-$val->sale_price ?> off</span>
                        <i class="bi-info-circle text-muted ms-2 lh-1 pointer"></i>
                        <input type="hidden" id="product<?= $val->item_id ?>" value='<?php echo json_encode($val,true) ?>'/>
                        <input type="hidden" id="product_id" value="<?= $val->item_id ?>" />                            
                    </div>
                    <div class="badge bg-success rounded-0">In Stock</div>
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0)" class="details-count-input">
                                <span class="decreamentbtn" data-product_id="<?= $val->item_id; ?>">
                                    <i class="bi-dash-lg ms-2"></i>
                                </span>
                            <input type="text" class="text-center count-class" value="1" id="count">
                            <span class="increamentbtn" data-product_id="<?= $val->item_id; ?>">
                                <i class="bi-plus-lg me-2"></i>
                            </span>
                        </a>
                        <a href="#" class="text-black text-decoration-none">
                            <i class="bi-heart font-20 ms-4 text-danger" id="wishlist_btn"></i>
                        </a>
                        </div>
                        
                    </div>
                 

                    <div class="mt-3">
                        <a href="<?php echo site_url($store_info->store_username.'/cart'); ?>"
                            class="w-50 m-w-100 rounded-0 text-uppercase font-14 btn btn-outline-dark add-cart">Add To
                            cart</a>
                        <a href="<?= site_url($store_info->store_username.'/place_order'); ?>" class="w-50 m-w-100 rounded-0 text-uppercase font-14 btn btn-dark mt-3">Place Order</a>
                    </div>
                    <div class="mt-4">
                        <div class="form-group mb-2">
                            <label for="" class="fw-500 form-label mb-1">Description</label>
                            <div class="text-muted"><?= $val->description ?></div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="me-4 text-muted">ITEM CODE: <span class="text-dark fw-500"><?= $val->item_code ?></span></span>
                        <span class="fw-500 text-dark">Category: <span class="text-muted fw-normal"><?= $val->category; ?></span></span>
                    </div>
                    <div class="mt-3">
                        <button class="social-btn btn-facebook"><i class="bi-facebook me-2 font-16"></i>SHARE</button>
                        <button class="social-btn btn-twitter"><i class="bi-twitter me-2 font-16"></i>TWEET</button>
                        <button class="social-btn btn-pintrest pt-1">
                            <img src="<?= site_url('public/assets/images/pintrest.svg') ?>" alt="" height="20">
                            PIN IT</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="csrfTokenName" value="<?= csrf_token() ?>" />
            <input type="hidden" id="csrfTokenValue" value="<?= csrf_hash() ?>" />
            <?php } ?>
        </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
$(function() {  
});
</script>
<?= $this->endSection() ?>