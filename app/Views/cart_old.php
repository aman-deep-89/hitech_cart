<?= $this->extend(config('SiteConfig')->homeLayout()) ?>
<?= $this->section('main') ?>
<div class="container">
<div class="row">
                <main class="col-md-9">
                    <div class="card">
                        <div class="table-responsive">
                            <?php  
                            $total_quantity=$total_price=0;
                            if(isset($data['cart']) && sizeof($data['cart'])) { ?>
                            <div id="error" class="text-danger"></div>
                            <table class="table table-borderless table-shopping-cart">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th>Product</th>
                                        <th width="120">Quantity</th>
                                        <th width="120">Price</th>
                                        <th class="text-end" width="200"> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                    
                                        foreach($data['products'] as $val) { ?>
                                                <tr id="row<?= $val['item_id'] ?>">
                                                    <td>
                                                        <figure class="itemside">
                                                            <div class="aside"><img
                                                                    src="<?= site_url('public/uploads/'.$val['item_image']); ?>"
                                                                    class="img-sm img-thumbnail"></div>
                                                            <figcaption class="info ms-3">
                                                                <h6 class="mb-1"><?= $val['item_name'] ?></h6>
                                                                <p class="text-muted small"><?= $val['description'] ?></p>
                                                            </figcaption>
                                                        </figure>
                                                    </td>
                                                    <td>
                                                        <?php $qty=$data['cart'][$val['item_id']]['quantity']; ?>
                                                        <select class="form-select item_quantity" data-id="<?= $val['item_id'] ?>">
                                                            <option <?php if($qty==1) echo 'selected'; ?> >1</option>
                                                            <option <?php if($qty==2) echo 'selected'; ?>>2</option>
                                                            <option <?php if($qty==3) echo 'selected'; ?>>3</option>
                                                            <option <?php if($qty==4) echo 'selected'; ?>>4</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="price-wrap">
                                                            <var class="price">₹ <?= $val['sale_price']*$qty ?></var>
                                                            <small class="text-muted text-decoration-line-through"> ₹ <?= $val['mrp']*$qty ?>
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="" class="btn btn-light cart-remove remove_item" data-id="<?= $val['item_id'] ?>"> <i class="bi-trash-fill text-danger"></i> Remove</a>
                                                    </td>
                                                </tr>
                                    <?php $total_quantity+=$qty; $total_price+=($val['sale_price']*$qty); } ?>
                                </tbody>
                            </table>
                            <?php } else { ?>
                               Your cart is empty
                            <?php } ?>
                        </div>
                        <div class="card-body border-top d-flex">
                            <div>
                                <a href="<?= site_url('Home') ?>" class="btn btn-sm cart-remove btn-light"> <i
                                        class="bi-chevron-left"></i> Continue shopping </a>
                            </div>
                            <div class="ms-auto">
                                <?php if(isset($data['cart']) && sizeof($data['cart'])) { ?>
                                        <a href="<?= site_url('Home/place_order') ?>" class="btn btn-sm btn-primary"> Make Purchase <i class="bi-chevron-right"></i> </a>
                                <?php } ?>
                            </div>

                        </div>
                    </div>

                    <div class="alert alert-success offer-alert mt-3 py-2">
                        <div class="d-flex align-items-center">
                            <i class="bi-tags-fill me-3 font-20 text-success"></i>
                            <div>Extra Upto <b>23% Off</b> on <b>Rs. 2490 </b> and above.</div>
                        </div>
                    </div>

                </main>
                <aside class="col-md-3">
                    <div class="card mb-3">
                        <div class="card-body">
                            <form>
                                <div class="form-group">
                                    <label class="form-label">Have coupon?</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Coupon code"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <a href="" class="text-decoration-none input-group-text btn-primary"
                                            id="basic-addon2">Apply</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>Subtotal</dt>
                                <dd class="text-end">₹ <?= $total_price ?></dd>
                            </dl>
                            <dl class="dlist-align text-danger">
                                <dt>Discount:</dt>
                                <dd class="text-end">- ₹ 00.00</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>GST:</dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <dl class="dlist-align">
                                <dt>Delivery Charges <i class="bi-info-circle lh-1 ms-2 pointer"></i></dt>
                                <dd class="text-end">₹ 0.00</dd>
                            </dl>
                            <hr>
                            <dl class="dlist-align">
                                <dt class="text-uppercase text-muted"> <strong> Total </strong></dt>
                                <dd class="text-end h6"><strong>₹ <?= $total_price ?></strong></dd>
                            </dl>
                        </div>
                    </div>
                </aside>
            </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
$(function() {      
    $('.item_quantity').change(function(e) {
        let item_id=$(this).data("id");
        let item_qty=$(this).val();
        $.ajax({
            url:'<?= site_url('Home/update_quantity') ?>',
            data:'item_id='+item_id+'&quantity='+item_qty+'&<?= csrf_token() ?>=<?= csrf_hash() ?>',
            type:'POST',
            dataType:'json',
            success:function(res) {
                if(res.success) {
                    location.reload();
                }
                else $('#error').html(res.error);
            }
        });
    });
    $('.remove_item').click(function(e) {
        e.preventDefault();
        let item_id=$(this).data("id");
        console.log(item_id);
        $.ajax({
            url:'<?= site_url('Home/remove_item') ?>',
            data:'item_id='+item_id+'&<?= csrf_token() ?>=<?= csrf_hash() ?>',
            type:'POST',
            dataType:'json',
            success:function(res) {
                if(res.success) {
                    $('#row'+item_id).remove();
                    $('#total_qty').text(res.qty);
                    $('#total_price').text(res.price);
                }
                else $('#error').html(res.error);
            }
        });
    });         
});
</script>
<?= $this->endSection() ?>