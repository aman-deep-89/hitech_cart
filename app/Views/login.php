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
                                <h4 class="mb-4 green-heading">Sign In</h4>
                                <div class="ms-auto">
                                    <a href="<?= site_url($store_info->store_username.'/signup') ?>" class="btn btn-outline-primary btn-sm">Don't Have an account? Sign up</a>
                                </div>
                            </div>
							<form action="<?= site_url('public').route_to('login') ?>" method="post">
								<?= csrf_field() ?>

                                <div class="row delivery-section">
									<?php if ($auth_config->validFields === ['email']): ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" id="email" name="email" class="form-control form-control-sm <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?=lang('Auth.email')?>">
											<div class="invalid-feedback">
												<?= session('errors.login') ?>
											</div>
                                        </div>
                                    </div>
									<?php else: ?>
										<div class="form-group">
											<label for="login"><?=lang('Auth.emailOrUsername')?></label>
											<input type="text" class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
												name="login" placeholder="<?=lang('Auth.emailOrUsername')?>">
											<div class="invalid-feedback">
												<?= session('errors.login') ?>
											</div>
										</div>
									<?php endif; ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="form-label"><?=lang('Auth.password')?></label>
                                            <input type="password" id="password" name="password" class="form-control form-control-sm  <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>">
											<div class="invalid-feedback">
												<?= session('errors.password') ?>
											</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" name="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </div>                            
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