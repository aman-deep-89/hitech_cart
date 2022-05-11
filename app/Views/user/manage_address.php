<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>
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
                            <a href="<?= site_url('User') ?>" class="nav-link">My Orders</a>
                            <a href="#" class="nav-link">My Wishlist</a>
                            <a href="<?= site_url('User/manage_address') ?>" class="nav-link active">Manages Address</a>
                            <a href="#" class="nav-link">Profile Information</a>
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
                            <form action="" method="post" id="save_data">
                            <input type="hidden" name="<?= csrf_token() ?>" value='<?= csrf_hash() ?>' > 
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="full_name" class="form-label">Full Name</label>
                                            <input type="text" name="full_name" id="full_name" class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone_no" class="form-label">Phone Number</label>
                                            <input type="text" name="phone_no" id="phone_no"class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="address_type" class="form-label">Type of address</label>
                                            <select class="form-control form-control-sm required" name="address_type" id="address_type" aria-label="Type of address">
                                                <option selected>Home</option>
                                                <option value="1">Work</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pin_code" class="form-label">Pincode</label>
                                            <input type="text" name="pin_code" id="pin_code" class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" name="state" id="state" class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" id="city" class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="house_no" class="form-label">House No, Building Name</label>
                                            <input type="text" id="house_no" name="house_no" class="form-control form-control-sm required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="road_name" class="form-label">Road Name, Area, Colony</label>
                                            <input type="text" name="road_name" id="road_name" class="form-control form-control-sm required">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer d-flex">
                                <button class="ms-auto btn btn-sm btn-success" type="submit">Save Address</button>
                                <button id="loader" class="btn btn-sm btn-warning ml-2" style="display:none">Saving....</button>
                            </div>
                            </form>
                        </div>
                        <?php if(isset($data['address'])) { 
                            foreach($data['address'] as $val) { ?>         
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <div class="badge bg-secondary lh-0"><?= $val['address_type'] ?></div>
                                            <div class="dropdown ms-auto pointer">
                                                <i class="bi-three-dots-vertical" id="optionMenu" data-bs-toggle="dropdown"></i>
                                                <ul class="dropdown-menu" aria-labelledby="optionMenu">
                                                    <li><a class="dropdown-item" href="#">Edit</a></li>
                                                    <li><a class="dropdown-item" href="#">Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h6><?= $val['address_full_name'] ?></h6>
                                        <p class="mb-0"><?= $val['house_no'].' '.$val['road_name'].' '.$val['city'].' '.$val['state'].' '.$val['pin_code'] ?></p>
                                    </div>
                                </div>
                        <?php } } ?>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
  
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript" src="<?= site_url('public/vendor/validation/js/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/assets/js/form_save.js') ?>"></script>
<script type="text/javascript">

</script>
<?= $this->endSection() ?>