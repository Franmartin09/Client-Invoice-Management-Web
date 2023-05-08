<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Clientes & Facturas</title>
    <!-- AWESOME ICONS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
    
    <script type="text/javascript">
      function showLoading() {
        document.getElementById('loading').style.display='block';
      }
      function hideLoading() {
        document.getElementById('loading').style.display='none';
      }
    </script>
<style>
        .input-group-addon {
            font-size: 25px;
        }
        .center-block {
            display: table;
            margin-left: auto;
            margin-right: auto;
        }
        .input-group{
            margin-top: 40px;
            margin-bottom: 40px;
        }
        .size-title{
            margin-top: 20px;
            height: 80px;
        }
        .loading-style{
            text-align:center;
            position:fixed;
            width:100%;
            height:100%;
            top:0;
            bottom:0;
            background-color: rgba(255,255,255,0.85);
            z-index:9999;
            display:none;
        }
        .row{
            width:100%;
        }
        .form-check-input:checked{
            background-color: #712cf9;
            border-color: #712cf9;
        }
        .btn-outline-warning {
            --bs-btn-color: #712cf9;
            --bs-btn-border-color: #712cf9;
            --bs-btn-hover-bg: #712cf9;
            --bs-btn-hover-border-color: #712cf9;
            --bs-btn-active-bg: #712cf9;
            --bs-btn-active-border-color: #712cf9;
            --bs-btn-disabled-color: #712cf9;
            --bs-btn-disabled-border-color: #712cf9;
            --bs-btn-hover-color: #fff;
            --bs-btn-active-color: #fff;
        }
        .btn-primary {
            --bs-btn-color: #fff;
            --bs-btn-bg: #712cf9;
            --bs-btn-border-color: #712cf9;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #520dd9;
            --bs-btn-hover-border-color: #4c0bcb;
            --bs-btn-focus-shadow-rgb: 49,132,253;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #4c0bcb;
            --bs-btn-active-border-color: #4c0bcb;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #712cf9;
            --bs-btn-disabled-border-color: #712cf9;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        thead {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 1;
        }
        th,td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

    </style>
</head>

<body class="w-100">
    <!-- IMAGEN LOADING LOGO STP -->
    <div class="loading-style" id="loading">
            <img src="app/Views/templates/loading.gif" alt="Loading..." style="width:300px;margin-top:25vh;"> 
    </div> 
    <div class="row">
        <div class="col-md-4 mt-5 offset-md-4 text-center">
            <h1><?= esc($title) ?></h1>
        </div>
                    
        <?if ($title!='Login'){?>
            <div class="col-md-4 mt-4 text-end">
                <form method="post" action="">
                    <? if($title!='Home' and ((strstr($title,' ', true))!="Crear" and (strstr($title,' ', true))!="Editar")){?>
                        <button class="btn btn-outline-secondary me-2" style="font-size:30px;" name="volver"  onclick=showLoading()><i class="bi bi-arrow-90deg-left"></i></button>
                    <?}if((strstr($title,' ', true))=="Crear" or (strstr($title,' ', true))=="Editar" or (strstr($title,' de', true))=="Facturas"){?>
                        <button class="btn btn-outline-secondary me-2" style="font-size:30px;" name="home"  onclick=showLoading()><i class="bi bi-house"></i></button>
                    <?}?>
                    <button class="btn btn-outline-danger me-2.5" style="font-size:30px;"  name="logout" onclick=showLoading()><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        <?}?>
    </div>

