<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset="UTF-8">
  <title>Sistem Informasi Palembang Souvenir House</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <!-- Bootstrap 3.3.2 -->
  <link href="<?=base_url('assets/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />
  <!-- Font Awesome Icons -->
  <link href="<?=base_url('assets/plugins/fontawesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="<?=base_url('assets/plugins/ionicons/css/ionicons.min.css');?>" rel="stylesheet" type="text/css" />
  <!-- DATA TABLES -->
  <link href="<?=base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
  <link href="<?=base_url('assets/plugins/datatables/responsive.bootstrap.css');?>" rel="stylesheet" type="text/css" />
  <link href="<?=base_url('assets/plugins/datatables/jquery.dataTables.css');?>" rel="stylesheet" type="text/css" />
  <link href="<?=base_url('assets/plugins/datatables/buttons/css/buttons.dataTables.css');?>" rel="stylesheet" type="text/css" />
  <!-- <link rel="stylesheet" type="text/css" href="<?=base_url('assets/datatables2/datatables.min.css');?>"/> -->
  <link rel="stylesheet" href="<?= base_url() ?>assets/sweetalert/sweetalert.css">

  <!-- Theme style -->
  <link href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
     folder instead of downloading all of them to reduce the load. -->
     <link href="<?=base_url('assets/dist/css/skins/_all-skins.min.css');?>" rel="stylesheet" type="text/css" />

     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
     <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
      <![endif]-->
      
      
      <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery-ui.css')?>">
      <link rel="stylesheet" href="<?=base_url('assets/plugins/datepicker/datepicker3.css');?>">
      <style>
      .katalog{
        width:100%;
        max-width:160px;
      }
    </style>
    <script src="<?=base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js');?>"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?=base_url('assets/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?=base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>    
    <!-- FastClick -->
    <script src='<?=base_url('assets/plugins/fastclick/fastclick.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/jquery.dataTables.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/dataTables.bootstrap.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/dataTables.responsive.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/buttons/js/dataTables.buttons.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/buttons/js/buttons.html5.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/buttons/js/buttons.flash.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/buttons/js/buttons.print.min.js');?>'></script>
    <script src='<?=base_url('assets/plugins/datatables/buttons/js/buttons.colVis.min.js');?>'></script>
    <!-- <script type="text/javascript" src="<?=base_url('assets/datatables2/datatables.min.js');?>"></script> -->

    <!-- AdminLTE App -->
    <script src="<?=base_url('assets/dist/js/app.min.js');?>" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/sweetalert/sweetalert.min.js"></script>
    <script src="<?=base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>    

    <script src="<?=base_url('assets/js/jquery-ui.js')?>"></script>

    <?php
    function TanggalIndo($date=""){
     $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

     $tahun = substr($date, 0, 4);
     $bulan = substr($date, 5, 2);
     $tgl   = substr($date, 8, 2);
     if ($date=="0000-00-00") {
       return "-";
     }
     else {
       $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;    

       return($result); 
     }
     
   }
   function hari($date)
   {
    $day = date('D', strtotime($date));
    $dayList = array(
     'Sun' => 'Minggu',
     'Mon' => 'Senin',
     'Tue' => 'Selasa',
     'Wed' => 'Rabu',
     'Thu' => 'Kamis',
     'Fri' => 'Jumat',
     'Sat' => 'Sabtu'
   );
    return ($dayList[$day]);
  }
  function br2nl( $input ) {
     $out = str_replace( "<br>", "\n", $input );
     $out = str_replace( "<br/>", "\n", $out );
     $out = str_replace( "<br />", "\n", $out );
     $out = str_replace( "<BR>", "\n", $out );
     $out = str_replace( "<BR/>", "\n", $out );
     $out = str_replace( "<BR />", "\n", $out );
     return $out;
}
  ?>

</head>
<body class="skin-red layout-top-nav">
  <div class="wrapper">

    <header class="main-header">               
      <nav class="navbar navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <a href="<?php echo site_url();?>" class="navbar-brand"><b>Invoice System</b></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
            </button>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
              <li><a href="<?php echo site_url();?>"><span class="fa fa-home"></span> Home</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Invoice<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo site_url('invoice');?>">Invoice</a></li>
                  <li><a href="<?php echo site_url('invoice/invoice_reports');?>">Invoice Reports</a></li>
                  <?php if ($this->session->userdata('hak_akses')==1): ?>
                   <li><a href="<?php echo site_url('omset');?>">Catat Omset</a></li>      
                 <?php endif ?>
               </ul>
             </li>
             <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Barang<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo site_url('ajaxform');?>">Laporan Barang</a></li>
                <li><a href="<?php echo site_url('barang');?>">Tambah stok</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Bahan<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo site_url('bahan/report');?>">Laporan Bahan baku</a></li>
                <li><a href="<?php echo site_url('bahan');?>">Tambah</a></li>

              </ul>
            </li>
            <li><a href="<?php echo site_url('agen');?>"> Agen</a></li>
            <li><a href="<?php echo site_url('barang/harga');?>"> Katalog</a></li>
            <?php if ($this->session->userdata('hak_akses')==1): ?>
              <li><a href="<?php echo site_url('keuangan');?>"> Keuangan</a></li>
            <?php endif ?>
            <li><a href="<?php echo site_url('plan');?>"> Plan</a></li>
            <?php if ($this->session->userdata('hak_akses')==1): ?>
             <li><a href="<?php echo site_url('absen');?>">Absen</a></li>      
           <?php endif ?>
           <?php if ($this->session->userdata('user')==true): ?>
             <li><a href="<?php echo site_url('login/keluar');?>">Keluar</a></li>      
             <?php 
             else :  ?><li><a href="<?php echo site_url('login/');?>">Login</a></li>   

           <?php endif ?>


         </ul>
       </div><!-- /.navbar-collapse -->
     </div><!-- /.container-fluid -->
   </nav>
 </header>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

  </section>

  <!-- Main content -->
  <section class="content">
          <!-- Info boxes -->