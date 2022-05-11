<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" type="text/css" href="<?= site_url('public/vendor/imgpicker/imgPicker.css') ?>" />
<?= $this->endSection() ?>
<?= $this->section('main') ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Settings</h1>            
          </div>

          <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
            <?php $validation =  \Config\Services::validation(); ?>
            <?php
            // To print success flash message
            if (session()->get("success")) {
            ?>
                <div class="alert alert-success">
                    <?= session()->get("success") ?>
                </div>
            <?php
            }
            ?>

            <?php
            // To print error messages
            if (!empty($data['errors'])) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($data['errors'] as $field => $error) : ?>
                        <p><?= $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>     
            <?php
            if (session('errors')) : ?>
                <div class="alert alert-danger">
                    <?php foreach (session('errors') as $field => $error) : ?>
                        <p><?= $error ?></p>
                    <?php endforeach ?>
                </div>
            <?php endif ?>           
                <?php 
                echo form_open(site_url('user/save_settings'),'class="user"'); ?>
                        <div class="form-group"> 
                            <label>Password <small>(leave it blank to keep it unchanged)</small></label>                       
                            <?php echo form_input($data['form_fields']['password']); 
                            if ($validation->getError('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>                                
                                <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <?php echo form_input($data['form_fields']['confirm_password']); 
                            if ($validation->getError('confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('confirm_password') ?>
                                    </div>                                
                                <?php endif; ?>
                        </div> 
                        <div class="form-row">
                        <div class="col-md-5">
                            <?php $settings=config('SiteConfig')->getImages(); ?>
                            <label>Profile Image</label>
                            <input type="hidden" name="profile_img" id="image_name2" value="<?php echo old('profile_img') ? old('profile_img') : (user()->profile_img ? user()->profile_img : 'logo.jpg'); ?>" />
                            <div class="image-wrapper" style="height:100px;">
                            <img src="<?php echo site_url('public/uploads/')?><?php echo old('profile_img') ? old('profile_img') : (user()->profile_img ? user()->profile_img : 'logo.jpg'); ?>" class="logo2 image1" width="100px" height="100px">
                            <button type="button" class="profile-img btn btn-info">Edit</button>
                            </div>
                        </div>
                        <?php if(in_groups('Admin')) { ?>
                        <div class="col-md-4">
                            <label>Logo</label>
                            <input type="hidden" name="logo" id="image_name" value="<?php echo old('logo') ? old('logo') : (get_settings()? get_settings()->logo : 'logo.jpg'); ?>" />
                            <div class="image-wrapper" style="height:220px;">
                            <img src="<?php echo site_url('public/uploads/')?><?php echo old('logo') ? old('logo') : (get_settings() ? get_settings()->logo : 'logo.jpg'); ?>" class="avatar image1" width="200px" height="100px">
                            <button type="button" class="edit-avatar btn btn-info">Edit</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Favicon</label>
                            <input type="hidden" name="favicon" id="image_name3" value="<?php echo old('logo') ? old('logo') : (get_settings()? get_settings()->favicon : 'logo.jpg'); ?>" />
                            <div class="image-wrapper" style="height:100px;">
                            <img src="<?php echo site_url('public/uploads/')?><?php echo old('logo') ? old('logo') : (get_settings()? get_settings()->favicon : 'logo.jpg'); ?>" class="logo3 image1" width="20px" height="20px">
                            <button type="button" class="edit-logo3 btn btn-info">Edit</button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>                      
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <hr>
                  <?php echo form_close(); ?>
            </div>
        </div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript" src="<?= site_url('public/vendor/imgpicker/imgPicker.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/vendor/imgpicker/jquery.Jcrop.min.js') ?>"></script>
<script type="text/javascript">
  jQuery(function($) {  
    function net(){             
	var val2 = $(".image1").attr('src');
	var res1 = val2.split("?");
	var res12 = res1[0].split("../files/");
    $('#image_name').val(res12[1]);	
}  
    $('.edit-avatar').imgPicker({
        el: '.avatar',
        type: 'logo',  
        width:500,  
        minWidth: 100,
        minHeight: 100,
        title: 'Change your Logo',
        aspectRatio:'3:1',
        dataEl : 'image_name',
        _token: "<?= csrf_hash() ?>",
        api: '<?php echo site_url('ImagePicker/upload_image'); ?>',
	});
	 $('.ip-save').click( function(){   
            net();
    });
    $('.profile-img').imgPicker({
        el: '.logo2',
        type: 'profile_img',  
        width:300,  
        minWidth: 100,
        minHeight: 100,
        title: 'Change your Profile Image',
        aspectRatio:'1:1',
        dataEl : 'image_name2',
        _token: "<?= csrf_hash() ?>",
        api: '<?php echo site_url('ImagePicker/upload_image'); ?>',
	});
    $('.edit-logo3').imgPicker({
        el: '.logo3',
        type: 'favicon',  
        width:200,  
        minWidth: 20,
        minHeight: 20,
        title: 'Change your Logo',
        aspectRatio:'3:2',
        dataEl : 'image_name3',
        _token: "<?= csrf_hash() ?>",
        api: '<?php echo site_url('ImagePicker/upload_image'); ?>',
	});
});
  </script>
<?= $this->endSection() ?>