<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Found</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="<?php echo site_url('public/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('public/assets/css/bootstrap-icons.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('public/assets/css/style.css'); ?>">

</head>

<body>
   
    <div class="container">
        <div class="mt-4">
            <div class="d-flex mb-5 align-items-center flex-wrap cart-parent">
                <div>
                    <a href="<?= site_url() ?>" class="btn btn-sm btn-outline-primary px-4">Home</a>
                </div>
                <div class="ms-3">
                    <a href="<?= site_url() ?>" class="btn btn-sm cart-remove btn-light"> <i class="bi-chevron-left"></i>
                        Not Found </a>
                </div>
            </div>
            <div class="row">
               The Store page you requested is not found.    
            </div>
        </div>
    </div>     
</body>


</html>