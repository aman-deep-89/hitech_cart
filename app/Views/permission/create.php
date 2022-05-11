<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">New Permission</h1>
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
                <?php echo form_open(site_url('public').route_to('permission/create'),'class="user"'); ?>
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
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                        <hr>
                  <?php echo form_close(); ?>
            </div>
        </div>
<?= $this->endSection() ?>