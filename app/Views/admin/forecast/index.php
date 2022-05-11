<?= $this->extend(config('SiteConfig')->adminLayout()) ?>
<?= $this->section('main') ?>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
            <a href="<?php echo site_url('forecast/create'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add new</a>
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
                    <thead><tr><th>Sr No.</th><th>Forecast Category</th><th>Description</th><th>Start Month</th><th>Types</th><th>Total Forecast</th><th>Actions</th></tr></thead>
                    <?php $i=1; foreach($data['list'] as $val) { 
                        ?>
                        <tr><th><?php echo $i; ?></th><th><?php echo $val->fc_name; ?></th><th><?php echo $val->fc_description; ?></th><td><?php echo $val->fc_start_month!=null ? date('M',mktime(0,0,0,$val->fc_start_month)) : 'Current Month'; ?></td><td><?php echo $val->types; ?></td><th>-</td><th><a href="<?php echo site_url('forecast/edit/'.$val->fc_id) ?>"><i class="fa fa-edit"></i></a> <a href="#" data-fc_id="<?php echo $val->fc_id; ?>" data-toggle="modal" data-route="<?php echo site_url('forecast/delete') ?>" data-target="#deleteForecast"><i class="text-danger fa fa-trash"></i></a></th></tr>
                    <?php $i++; } ?>
                </table>
                <?php } ?>
            </div>
        </div>
        <div class="modal fade" id="deleteForecast" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="deleteForecast" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <?php echo form_open(site_url('forecast/delete'),'id="delete_form"'); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">This action is not reversible.</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this?
                    <input type="hidden" id="fc" name="fc_id">
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
    $('#deleteForecast').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var forecast = button.data('fc_id'); 
        console.log("id="+forecast);
        var modal = $(this);
        modal.find('.modal-body #fc').val(forecast);
    });
});
</script>
<?= $this->endSection() ?>