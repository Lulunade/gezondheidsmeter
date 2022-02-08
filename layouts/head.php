<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
if(str_replace(".php","",basename($_SERVER['REQUEST_URI'])) === "" ||str_replace(".php","",basename($_SERVER['REQUEST_URI'])) === "/"){
    ?>
    <title>gezondsheidmeter | home</title>
<?php
}else {?>
<title>gezondsheidmeter | <?= str_replace(".php","",basename($_SERVER['REQUEST_URI'])) ?></title><?php
}
?>
<link href="./css/grid-min.css" rel="stylesheet">
<link href="./css/styles.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/SweetAlerts.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.11.1/dist/sweetalert2.all.min.js"></script>