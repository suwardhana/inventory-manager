
<!--  Notification  -->
<?php $msg = $this->session->flashdata('msg1'); if((isset($msg)) && (!empty($msg))) { ?>
<div class="alert alert-danger" >
  <a href="#" class="close" data-dismiss="alert">&times;</a>
  <b><?php print_r($msg); ?></b>
</div>
<?php } ?>

<section class="content">
  <div class="row">
   <div class="col-lg-12">    

   </div>
   <div class="col-lg-12">
    <!-- general form elements -->     
    <div class="box box-primary">
      <div class="box-header">
        <h3 class="box-title">Laporan Uang Keluar</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
      <div class="col-lg-12">
        <div class="col-md-1"><a href="<?php echo site_url('keuangan/daftar_pengeluaran');?>" class="btn btn-primary">Kategori</a></div>
          <div class="col-md-1"><a href="<?php echo site_url('keuangan/pengeluaran_baru');?>" class="btn btn-primary">Add</a></div>
      </div>
      <br><br>
        <div class="col-lg-8">
          <form action="#" method="POST">
            <div class="col-md-4">
              <select name="bulan" id="" class="form-control">
                <option value="0">all</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
            <div class="col-md-2">
              <select name="tahun" id="" class="form-control">

                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
              </select>
            </div>
            <div class="col-md-4">
              <select name="jenis" id="" class="form-control">

                <option value="all">all</option>
                <?php foreach ($jenis as $val): ?>
                  <option value="<?php echo $val->id_jenis ?>"><?php echo $val->jenis_keluar ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-2">
              <input type="submit" class="btn btn-primary" name="filter_date" value="Filter">            
            </div>
          </form>
          
        </div>  

        <table class="table table-bordered table-hover datatables-example">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>tanggal</th>
              <th>Jenis</th>
              <th>Keterangan</th>
              <th>Jumlah = <?php echo number_format($jumlah->jumlah); ?></th>
              <?php if(!$ispegawai){ ?><th>aksi</th><?php } ?>
            </tr>
          </thead>
          <tbody>              
            <?php
            $i=1;
            if(!empty($isi)){
              foreach ($isi as $val){
                echo "<tr>";
                echo "<td>".$i++."</td>";
                echo "<td>".TanggalIndo($val->tanggal)."</td>";
                echo "<td>".$val->jenis_keluar."</td>";
                echo "<td>".$val->keterangan."</td>";
                echo "<td> Rp.".number_format($val->jumlah)."</td>";
                if(!$ispegawai){echo "<td><a href='#delete_".$val->id."'class='btn btn-danger' data-toggle='modal'>Delete</button></td>"; }
                echo "</tr>";
              }
            }
            ?>    
          </tbody>
        </table>

      </div>




      <!--Delete Modal -->
      <?php if(!empty($isi)){
        foreach ($isi as $v){?>
        <div class="modal fade" id="delete_<?php echo $v->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Warning !</h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger" align="center">
                  Are you sure to delete !
                </div>
                <div align="center">
                  <form action="<?php echo site_url('keuangan/delete2');?>" method="post">
                    <input type="hidden" value="<?php echo $v->id;?>" name="id">
                    <button type="submit" class="btn btn-primary">yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                  </form>
                </div>

              </div>
              <div class="modal-footer">

              </div>
            </div>
          </div>
        </div>
        <?php } } ?>