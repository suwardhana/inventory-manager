
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
            <h3 class="box-title">Invoice reports</h3>
          </div><!-- /.box-header -->
          <div class="box-body">  
            <?php if ($omset==null){ ?>
              <div class="alert alert-info"><h3>Target Omset Belum dicatat</h3></div>
              <?php }else{ ?>
                <div class="alert alert-info"><h3>Target Omset adalah : Rp. <?php echo number_format($omset->t_omset); ?></h3></div>
                <?php } ?>
                <table  class="table table-bordered table-hover datatables-example">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th width="12%">Faktur</th>
                      <th width="10%">Date</th>
                      <th >Customer</th>
                      <th>DP</th>
                      <th>Total</th>
                      <?php if(!$ispegawai){?><th>Modal</th>
                      <th>Untung</th><?php } ?>
                      <th>PIC</th>
                      <th width="25%">Rincian</th>
                      <th>View</th> 
                      <?php if(!$ispegawai){?>
                        <th width="10%">Delete</th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>              
                      <?php
                      $i=1;$hasil=0;$untung=0;$modal2=0;$selisih=0;
                      if(!empty($invoice)){
                        foreach ($invoice as $val){

                          $modal3=0;
                          $untung2=0;
                          $untung3=0;
                          $total=0;
                          $hasil = $hasil + $val->grand_total;
                          $banyak=explode(',',$val->name);
                          $count=count($banyak);
                          $modal=explode(',',$val->modal);

                          $amount=explode(',',$val->amount);
                          $qty=explode(',',$val->quantity);
                          
                          if($modal)
                          {
                           for($k=0;$k<$count;$k++)
                           {
                            if($modal[$k]!=null)
                            {
                             $modal2=$modal2+((int)$modal[$k]*(int)$qty[$k]);
                             $modal3=$modal3+((int)$modal[$k]*(int)$qty[$k]);
                             $untung=$untung+(int)$amount[$k];
                             $untung2=$untung2+(int)$amount[$k];
                             $total=$total+(int)$amount[$k];
                           }
                           else if($modal[$k]==null){$hasil = $hasil - (int)$amount[$k];}
                         }
                         $untung3=$untung2-$modal3;
                       }
                       
                       echo "<tr>";
                       echo "<td>".$i++."</td>";
                       echo "<td>".$val->faktur."</td>";
                       echo "<td>".TanggalIndo($val->date)."</td>";
                       echo "<td>".$val->customer_name."</td>";
                       if($val->dp==$val->grand_total)
                        {echo "<td>-</td>";}
                      else echo "<td>".number_format($val->dp)."</td>"; 
                      echo "<td>".number_format($total)."</td>";
                      if(!$ispegawai)
                        {echo "<td>".number_format($modal3)."</td>";
                      echo "<td>".number_format($untung3)."</td>";}
                      echo "<td>".$val->pic."</td>";
                      $rinci1 = null;$rinci2 = null;
                      $rinci1 = explode(",", $val->name);
                      $rinci2 = explode(",", $val->rate);
                      $rinci3 = explode(",", $val->quantity);
                      $banyak2 = count($rinci1);
                      echo "<td>";
                      for($x=0;$x<$banyak2;$x++){
                       echo $rinci1[$x]." (".$rinci3[$x].") - Rp.".number_format($rinci2[$x]);
                       echo "<br>";
                     }
                     echo "</td>";
                     echo "<td>";
                     echo "
                    <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-placement='bottom' data-target='#edit' onclick='edit(".$val->id.")'>Faktur</button></td><td>
                    <button type='button' class='btn btn-danger btn-sm' onclick='deleteData(".$val->id.")'>Delete</button>
                  ";
                     echo "</td>";

                    echo "</tr>";
                    
                    
                  }
                  $selisih = $untung - $modal2;
                }
                ?>    
              </tbody>
              
              
              
            </table>
            <?php if ($omset!=null){ ?>
              <?php if ($omset->t_omset>$hasil): ?>
                <div class="alert-danger alert"><h4>Target Belum Tercapai, </h4>
                  <div class="col-sm-2">Total Omset  </div><?php echo ":".number_format($untung);?></h4><br>
                  <div class="col-sm-2">Total Modal  </div> <?php echo ":".number_format($modal2);?><br>
                  <div class="col-sm-2">Total Keuntungan  </div><?php echo ":".number_format($selisih);?><br>
                <?php endif ?>
                <?php if ($omset->t_omset<$hasil): ?>
                  <div class="alert-success alert"><h4>Target Telah Tercapai, </h4>
                    <div class="col-sm-2">Total Omset </div><?php echo ":".number_format($untung);?></h4><br>
                    <div class="col-sm-2">Total Modal </div> <?php echo ":".number_format($modal2);?><br>
                    <div class="col-sm-2">Total Keuntungan </div><?php echo ":".number_format($selisih);?><br>
                  </div>
                <?php endif ?>
                <?php } ?>
              </div>

              <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content" style="width:800px;margin-left:-120px">
                    <div class="modal-body" id="report">
                      <div class="row">
                        <div style='float: right;'><div class="" style="margin-right:40px;margin-top:10px">No : <div id="nofaktur"></div><br>Tanggal : <div id="tanggal"></div><br>Kepada Yth. <br><div id="namacustomer"></div></div></div>
                        <div style='float: left;margin-left:20px'><img src=<?=base_url('assets/psh.png');?> width='100px' /></div>
                        <h6>Menjual berbagai macam <br>Produk Souvenir khas Palembang<br>Olahan Kain Songket khas Palembang,<br>Kain Songket Palembang, dll.<br>
                         Jln.Kiranggo Wirosentiko No.462 Rt.12-30 Ilir Palembang<br>HP.+6285267390065 (Adit)</h6>
                       </div>
                       <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="5%">No</th>                  
                            <th>Jenis Barang</th>
                            <th width="10%">Harga</th> 
                            <th width="7%">Banyak</th>  
                            <th  width="20%" align='center'>Jumlah</th>
                          </tr>
                        </thead>
                        <tbody id="isitabel">

                        </tbody>
                      </table> 
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="return printdiv('report')"><i class="fa fa-print"></i>&nbspPrint</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">close</button>

                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <script type="text/javascript">
                function edit(id) {
                  $.ajax({
                    url: '<?= base_url('invoice/invoice_reports') ?>',
                    type: 'POST',
                    data: {
                      id: id,
                      get: true
                    },
                    success: function(response) {
                      response = JSON.parse(response);
                      console.log(response);
                      $('#namacustomer').html(response.customer_name);
                      $('#nofaktur').html(response.faktur);

                      $('#tanggal').html(response.date);
                      var amount = response.amount.split(',');
                      var name = response.name.split(',');
                      var quantity = response.quantity.split(',');
                      var rate = response.rate.split(',');
                      var total = response.grand_total;
                      var dp = response.dp;
                      if(dp==total)
                      {
                        var lunas = true;
                      }
                      else var lunas = false;
                      var stringtabel = "";
                      for (var i = 0;i<amount.length; i++) {
                        stringtabel += "<tr>";
                        var nomor = i+1;
                        stringtabel += "<td>"+nomor+"</td>";
                        stringtabel += "<td>"+name[i]+"</td>";
                        stringtabel += "<td>"+c_format(rate[i],"Rp.")+"</td>";
                        stringtabel += "<td>"+quantity[i]+"</td>";
                        stringtabel += "<td>"+c_format(amount[i],"Rp.")+"</td>";
                        stringtabel += "</tr>";
                      }
                      stringtabel += "<tr><td align='right' colspan='4'>Jumlah = </td><td>"+c_format(total,"Rp.");
                      if(!lunas) {
                        stringtabel += "</td></tr><tr><td align='right' colspan='4'> DP = </td><td>"+c_format(dp,"Rp.");
                      }
                      stringtabel += "</td></tr>";
                      $('#isitabel').html(stringtabel);


                    }
                  });
                }
                function deleteData(id) {
                  swal({
                    title: "Apakah Anda Ingin Menghapus Data ini?",
                    text: ' ',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak",
                    closeOnConfirm: true,
                    closeOnCancel: true
                  },
                  function(isConfirm){
                    if (isConfirm) {
                      $.ajax({
                        url: '<?= base_url('invoice/invoice_reports') ?>',
                        type: 'POST',
                        data: {
                          delete: true,
                          id: id
                        },
                        success: function() {
                          window.location = '<?= base_url('invoice/invoice_reports') ?>';
                        }
                      });
                    }
                  });
                }
                function c_format(n, currency) {
                  xx = Math.round(n);
                  return currency + xx.toFixed(0).replace(/./g, function(c, i, a) {
                    return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
                  });
                }
              </script>
              <script type="text/javascript">
                function printdiv(divID){
                  var divElements = document.getElementById(divID).innerHTML;
                  var oldPage = document.body.innerHTML;
                  document.body.innerHTML = 
                  "<html><head><title></title></head><body><div class='col-md-6'>  " + 
                  divElements + "<div class='col-sm-6'>Keterangan : Barang yang telah dibeli tidak dapat dikembalikan kecuali ada perjanjian.<br><br>Tanda terima,<br><br><br>________________</div><div class='col-sm-4'><br><br><br>Hormat Kami,<br><br><br>___________________<br>Palembang Souvenir House</div></div></body></html>";
                  window.print();
                  document.body.innerHTML = location.reload(false);
                }

              </script>
              <script type="text/javascript">
                $(document).ready(function() {
                  $('#example').DataTable();
                } );
              </script>