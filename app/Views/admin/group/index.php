<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
            <a href="<?php echo site_url('groups/create'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i>Add new</a>
          </div>

          <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <?php 
                if(session()->has("message")){ ?>
                    <div class="alert alert-success"><?php echo session()->get('message'); ?></div>
                <?php }
                if(session()->has("error")){ ?>
                    <div class="alert alert-danger"><?php echo session()->get('error'); ?></div>
                <?php } ?>
                <?php 
                if (! empty($errors)) { ?>
                    <div class="alert alert-success"><?php echo $status; ?></div>
                <?php } 
                if(!empty($data['list'])) { ?>
                <table class="table">
                    <thead><tr><th>Sr No.</th><th>Group</th><th>Description</th><th>Permissions</th><th>Actions</th></tr></thead>
                    <?php $i=1; foreach($data['list'] as $val) { 
                        ?>
                        <tr><th><?php echo $i; ?></th><th><?php echo $val->grp_name; ?></th><th><?php echo $val->grp_desc; ?></th><td><?php echo $val->per; ?></td><th><a href="<?php echo site_url('group/edit/'.$val->grp_id) ?>"><i class="fa fa-edit"></i></a> <a href="#" data-grp_id="<?php echo $val->id; ?>" data-toggle="modal" data-route="<?php echo site_url().route_to('group/delete') ?>" data-target="#deleteGroup"><i class="text-danger fa fa-trash"></i></a></th></tr>
                    <?php $i++; } ?>
                </table>
                <?php } ?>
            </div>
        </div>
        <div class="modal fade" id="deleteGroup" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteGroup" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <?php echo form_open(route_to('group/delete'),'id="delete_form"'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">This action is not reversible.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this?
                    <input type="hidden" id="group" name="group_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-white" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>        
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
$(function() {
    $('#deleteGroup').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var group = button.data('id'); 
        console.log("id="+group);
        var modal = $(this);
        modal.find('.modal-body #group').val(group);
    });
});
</script>
<?= $this->endSection() ?>