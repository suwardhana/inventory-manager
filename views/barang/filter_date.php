
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
        <div class="col-md-8">
          <form action="#" method="POST">
            <div class="col-md-4">
              <select name="bulan" id="" class="form-control">
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>
            <div class="col-md-4">
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
              <input type="submit" class="btn btn-primary" name="filter_date" value="Filter">            
            </div>
          </form>
        </div>
        <div class="col-md-4">

        </div> 
      </div>
      <div class="col-lg-12">
        <!-- general form elements -->

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Barang Paling Laku <?= $bulan." - ".$tahun ?></h3>
          </div><!-- /.box-header -->
          <div class="box-body"> 
            <table class="table table-bordered table-hover datatables-example">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="10%">Id Barang</th>
                  <th>Nama Barang</th>
                  <th width="10%">Jumlah Laku</th>
                  <th width="10%">Omset</th>
                </tr>
              </thead>
              <tbody>              
                <?php
                $i=1;
                if(!empty($invoice)){
                  foreach ($invoice as $val){

                    echo "<tr>";
                    echo "<td>".$i++."</td>";
                    echo "<td>".$val->id_barang."</td>";
                    echo "<td>".$val->nama."</td>";
                    echo "<td>".$val->laku."</td>";
                    echo "<td>".number_format($val->omset)."</td>";
                    echo "</tr>";

                  }
                }
                ?>    
              </tbody>
            </table>




          </div>
        </div>
      </div>

    </div>








