<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('pageStyles') ?>
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/chosen.min.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/prism.css') ?>" />
<link rel="stylesheet" type="text/css" href="<?= site_url('public/js/chosen/css/style.css') ?>" />
<?= $this->endSection() ?>
<?= $this->section('main') ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">New Group</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> View List</a>
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
                echo form_open(site_url('public').route_to('groups/create'),'class="user"'); ?>
                        <div class="form-group">                        
                            <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Name" value="<?php echo old('name'); ?>">
                            <?php if ($validation->getError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>                                
                                <?php endif; ?>
                        </div>
                        <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="description" name="description" placeholder="Description" value="<?php echo old('description'); ?>">
                        <?php if ($validation->getError('description')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('description') ?>
                                    </div>                                
                                <?php endif; ?>
                        </div>
                        <div class="form-group">
                        <?php 
                    echo form_dropdown('permissions[]',$data['permission'],1,'class="form-control chosen-select" multiple="multiple"'); ?>
                        <?php if ($validation->getError('permission')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('permission') ?>
                                </div>
                            <?php endif; ?>
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
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/chosen.jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/prism.js') ?>"></script>
<script type="text/javascript" src="<?= site_url('public/js/chosen/js/init.js') ?>"></script>
<?= $this->endSection() ?>