<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('main') ?>

<div class="section-content padding-y">
<div class="container">
        <div class="mt-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start w-100">
                                <h4 class="mb-4 green-heading">Register</h4>
                                <div class="ms-auto">
                                    <a href="<?= site_url($store_info->store_username.'/signin') ?>" class="btn btn-outline-primary btn-sm">Already have an account? Signin</a>
                                </div>
                            </div>
							<form action="<?= site_url().route_to('register') ?>" method="post">
								<?= csrf_field() ?>
                                <input type="hidden" name="store_username" value="<?= $store_info->store_username ?>" />
                                <?php if(session('errors.store_username')) { ?>
                                    <div class="alert alert-danger">The store name is not valid</div>
                                <?php } ?>
                                <div class="form-group">
                            <label for="email"><?=lang('Auth.email')?></label>
                            <input type="email" class="form-control <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                   name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                            <small id="emailHelp" class="form-text text-muted"><?=lang('Auth.weNeverShare')?></small>
                            <div class="text-danger"><?= session('errors.email') ?></div>
                        </div>

                        <div class="form-group">
                            <label for="username"><?=lang('Auth.username')?></label>
                            <input type="text" class="form-control <?php if(session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                                <div class="text-danger"><?= session('errors.username') ?></div>
                        </div>
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control <?php if(session('errors.full_name')) : ?>is-invalid<?php endif ?>" name="full_name" placeholder="Full Name" value="<?= old('full_name') ?>">
                                <div class="text-danger"><?= session('errors.full_name') ?></div>
                        </div>
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control <?php if(session('errors.mobile_number')) : ?>is-invalid<?php endif ?>" name="mobile_number" placeholder="Mobile Number" value="<?= old('mobile_number') ?>" maxlength="10">
                                <div class="text-danger"><?= session('errors.mobile_number') ?></div>
                        </div>

                        <div class="form-group">
                            <label for="password"><?=lang('Auth.password')?></label>
                            <input type="password" name="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                                <div class="text-danger"><?= session('errors.password') ?></div>
                        </div>

                        <div class="form-group">
                            <label for="pass_confirm"><?=lang('Auth.repeatPassword')?></label>
                            <input type="password" name="pass_confirm" class="form-control <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                                <div class="text-danger"><?= session('errors.pass_confirm') ?></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.register')?></button>
                        
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-4 blue-heading">Cart Summary</h5>
                            <dl class="dlist-align cart-summary">
                                <dt>Some name of item </dt>
                                <dd class="text-end">₹ 3000.00</dd>
                            </dl>

                            <dl class="dlist-align cart-summary">
                                <dt>Another name of item </dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <dl class="dlist-align cart-summary">
                                <dt>Apple AirPods 2</dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align cart-summary">
                                <dt class="fw-bold">To pay</dt>
                                <dd class="fw-bold text-end">₹ 3000.00</dd>
                            </dl>
                        </div>
                    </div>
                    <a id="placeOrder" class="btn btn-sm btn-primary w-100">
                        <b>Place Order</b> <br>
                        <small class="font-10">COD (Cash on Delivery)</small>
                    </a>
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
</div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>

<script type="text/javascript">
$(function() {                 
});
</script>
<?= $this->endSection() ?>