<?= $this->extend(config('SiteConfig')->stickyLayout()) ?>
<?= $this->section('pageStyles') ?>
<?= $this->endSection() ?>
<?= $this->section('main') ?>
<?php
$o_email=$invoice_no=$sub_total=$invoice_no=$customer_name=$contact_no=$address=$pin_code=$city=$delivery_type=$order_date='-';
if(isset($data['order_detail'])) {
    $o_email=$data['order_detail'][0]['o_email'];
    $invoice_no=$data['order_detail'][0]['invoice_no'];
    $sub_total=$data['order_detail'][0]['sub_total'];
    $invoice_no=$data['order_detail'][0]['invoice_no'];
    $customer_name=$data['order_detail'][0]['customer_name'];
    $contact_no=$data['order_detail'][0]['contact_no'];
    $address=$data['order_detail'][0]['o_address'];
    $pin_code=$data['order_detail'][0]['o_pin_code'];
    $city=$data['order_detail'][0]['o_city'];
    $delivery_type=$data['order_detail'][0]['delivery_type'];    
    $order_date=$data['order_detail'][0]['od_date'];
}
?>
<section class="section-pagetop bg">
        <div class="container">
            <div class="d-flex">
                <div>
                    <h2 class="title-page fw-bold mb-3">Thank you for your order !</h2>
                    <div><strong><?php if(!empty($o_email)) { ?>
                        Order invoice has been sent to <strong><?php echo $o_email ?>
                    <?php } else { ?>
                        Order has been received
                    <?php } ?>
                    </strong>
                    </div>
                </div>
                <div class="ms-5">
                    <i class="bi-check-circle-fill text-success order-place-check-icon"></i>
                </div>
            </div>
            
        </div>
    </section>
<div class="container">
<div class="mt-5">
    <article class="card order-group">
        <header class="card-header d-flex align-items-center">
            <div class="me-auto">
            <b>Order ID: <?= $invoice_no ?></b>
            </div>

            <button class="btn btn-sm btn-outline-success me-4 font-13">
                <i class="bi-whatsapp me-2"></i>Send Whatsapp
            </button>
            <span>Date/Time: <strong class="text-dark d-block"> <?= $order_date ?> </strong></span>
        </header>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 payment-block">
                    <h6 class="text-muted">Payment</h6>

                    <div class="font-15">Subtotal: ₹300.00</div>
                    <div class="font-15">Shipping fee: ₹0.00</div>
                    <div class="mt-2 fw-bold font-16">Total: ₹300.00 </div>

                </div>
                <div class="col-md-4 contact-block">
                    <h6 class="text-muted">Contact</h6>
                    <div class="font-15">
                        <div class="font-16"><?= $customer_name ?></div>
                        <div><i class="bi-telephone-fill font-12 me-2"></i> <?= $contact_no ?></div>
                        <div><i class="bi-envelope-fill font-12 me-3"></i><?= $o_email ?></div>
                    </div>
                </div>
                <div class="col-md-4 shipping-block">
                    <h6 class="text-muted">Shipping address</h6>
                    <p class="mb-2"> <?= $address.' '.$city.' '.$pin_code ?> </p>
                    <i class="fw-500"><?= $delivery_type ?></i>
                </div>
            </div> <!-- row.// -->
            <hr>

            <div class="my-4 d-md-flex align-items-start justify-content-between">
                <div class="d-flex align-items-start">
                    <i class="bi-clipboard-check text-success font-30"></i>
                    <div class="ms-3 text-muted">
                        <h6 class="mb-0">Order Confirmed</h6>
                        <p class="mb-0 fw-500">-</p>
                        <button class="btn btn-sm btn-outline-danger mt-3">Close Order</button>
                    </div>
            
                </div>
                <div class="w-auto flex-fill mx-5 mt-4 border"></div>
                <div class="d-flex align-items-center text-muted">
                    <i class="bi-truck font-30"></i>
                    <div class="ms-3">
                        <h6 class="mb-0">Order Shipped</h6>
                        <p class="mb-0 fw-500">-</p>
                    </div>
                </div>
                <div class="w-auto flex-fill mx-5 mt-4 border "></div>
                <div class="d-flex align-items-center text-muted">
                    <i class="bi-check-circle font-30"></i>
                    <div class="ms-3">
                        <h6 class="mb-0">Order Delivered</h6>
                        <p class="mb-0 fw-500">-</p>
                    </div>
                </div>
                <div class="w-auto flex-fill mx-5 mt-4 border "></div>
                <div class="d-flex align-items-center text-muted">
                    <i class="bi-arrow-repeat font-30"></i>
                    <div class="ms-3">
                        <h6 class="mb-0">Return Order</h6>
                        <p class="mb-0 fw-500">-</p>
                    </div>
                </div>
            </div>
            <hr>
            <ul class="list-group list-group-flush font-16">
                <?php 
                $total=0;
                foreach($data['order_detail'] as $od_detail) { ?>
                <li class="list-group-item d-flex align-items-center">
                    <img src="https://bootstrap-ecommerce.com/bootstrap-ecommerce-html/images/items/1.jpg"
                        alt="" srcset="" class="img-xs img-thumbnail">
                    <div class="ms-3">
                        <?= (int)$od_detail['od_quantity'] ?> x <?= $od_detail['item_name'] ?>
                    </div>
                    <div class="ms-auto">₹ <?= $od_detail['od_total_cost'] ?></div>
                </li>
                <?php $total+=$od_detail['od_total_cost']; } ?>  
                <li class="list-group-item d-flex align-items-center">
                    <div class="fw-500 text-uppercase">
                        Total
                    </div>
                    <div class="ms-auto fw-bold">₹ <?= $total ?></div>
                </li>             
            </ul>
        </div>
    </article>
</div>
<div class="card order-contact border-0">
    <div class="card-body text-center">
        <img src="assets/images/order.png" class="mx-auto d-block" alt="" width="70">
        <h5 class="my-4">Have any questions regarding your order?</h5>
        <button class="btn btn-outline-dark btn-sm me-2">
            <i class="bi-whatsapp me-2"></i>Whatsapp
        </button>
        <button class="btn btn-outline-dark btn-sm me-2">
            <i class="bi-telephone-fill me-2"></i>Call Us
        </button>
        <button class="btn btn-outline-dark btn-sm me-2">
            <i class="bi-envelope-fill me-2"></i>Email Us
        </button>
    </div>
</div>
</div>    
<?= $this->endSection() ?>
<?= $this->section('pageScripts') ?>
<script type="text/javascript">
</script>
<?= $this->endSection() ?>