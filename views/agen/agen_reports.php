
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
        <!-- general form elements -->     
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title">Invoice Agen reports - <?php foreach ($agen as $name){echo $name->nama;}?></h3>
          </div><!-- /.box-header -->
          <div class="box-body">  

            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td>No</td>
                  <td>Date</td>
                  <td>Total</td>   
                  <td>View</td> 
                  <?php if(!$ispegawai){?>
                    <td>Delete</td>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>              
                  <?php
                  $i=1;
                  if(!empty($invoice)){
                    foreach ($invoice as $val){
                      echo "<tr>";
                      echo "<td>".$i++."</td>";
                      echo "<td>".TanggalIndo($val->date)."</td>";
                      echo "<td>".number_format($val->grand_total)."</td>";  
                      echo "<td><a href='#myModal_".$val->id."'class='btn btn-primary' data-toggle='modal'>View</button></td>";       
                      if(!$ispegawai){echo "<td><a href='#delete_".$val->id."'class='btn btn-danger' data-toggle='modal'>Delete</button></td>";} 
                      echo "</tr>";
                    }
                  }
                  ?>    
                </tbody>
              </table>
            </div>

            <!--view  Modal -->

            <?php if(!empty($invoice)){
              foreach ($invoice as $vals){?>
                <div class="modal fade" id="myModal_<?php echo $vals->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content" style="width:800px;margin-left:-120px">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Invoice Item details</h4>
                      </div>
                      <div class="modal-body" id="report<?php echo $vals->id;?>">
                       <div class="row">

                        <div style='float: right;'><div class="" style="margin-right:40px;margin-top:50px">Tanggal : <?php echo TanggalIndo($vals->date);?><br>Kepada Yth. <br><?php echo $vals->nama_agen;?></div></div>
                        <div style='float: left;margin-left:20px'><img src=<?=base_url('assets/psh.png');?> width='100px' /></div>
                        
                        <h6>Menjual berbagai macam <br>Produk Souvenir khas Palembang<br>Olahan Kain Songket khas Palembang,<br>Kain Songket Palembang, dll.<br>
                         Jln.Kiranggo Wirosentiko No.462 Rt.12-30 Ilir Palembang<br>HP.+6285267390065 (Adit)</h6>
                       </div>
                       <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="5%">No</td>                  
                              <th>Jenis Barang</th>
                              <th width="10%">Harga</th> 
                              <th width="7%">Banyak</th>  
                              <th  width="20%" align='center'>Jumlah</th>  

                            </tr>
                          </thead>
                          <tbody>              
                            <?php


                            $lunas = true;


                            $item_name=explode(',',$vals->name);
                            $rate=explode(',',$vals->rate);
                            $quantity=explode(',',$vals->quantity);
                            $amount=explode(',',$vals->amount);
                            $count=count($item_name);
                            for($k=0;$k<$count;$k++)
                            {
                              $j=$k+1;

                              echo "<tr>";
                              echo "<td>".$j."</td>";        
                              echo "<td>".$item_name[$k]."</td>";
                              echo "<td>".$rate[$k]."</td>";
                              echo "<td align='center'>".$quantity[$k]."</td>";
                              echo "<td align='center'>".number_format($amount[$k])."</td>";
                              echo "</tr>";
                            }
                            echo "<tr><td align='right' colspan='4'>Jumlah = </td><td>";
                            echo " Rp ".number_format($vals->grand_total);
                            if(!$lunas) echo "</td></tr><tr><td align='right' colspan='4'> DP = </td><td> Rp ".number_format($vals->dp);
                            echo "</td></tr>";


                            ?>    
                          </tbody>

                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="return printdiv2('report<?php echo $vals->id;?>')"><i class="fa fa-print"></i>&nbspPrint</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">close</button>

                      </div>
                    </div>
                  </div>
                </div>
                <?php }}?>


                <!--Delete Modal -->
                <?php if(!empty($invoice)){
                  foreach ($invoice as $v){?>
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
                              <form action="<?php echo site_url('agen/delete_invoice');?>" method="post">
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

                    <script type="text/javascript">
                      function printdiv(divID){
      //Get the HTML of div
      var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
            "<html><head><title></title></head><body><div class='col-sm-3'>  " + 
            divElements + "<div class='col-sm-2'>Keterangan : Barang yang telah dibeli tidak dapat dikembalikan kecuali ada perjanjian.<br><br>Tanda terima, &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Hormat Kami,<br><br><br>________________&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;___________________<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Palembang Souvenir House</div></div></body></html>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = location.reload(false);

          }
        </script>
        <script type="text/javascript">
          function printdiv2(divID){
      //Get the HTML of div
      var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
            "<html><head><title></title></head><body><div class='col-sm-6'>  " + 
            divElements + "<div class='col-sm-2'>Keterangan : Barang yang telah dibeli tidak dapat dikembalikan kecuali ada perjanjian.<br><br>Tanda terima, &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Hormat Kami,<br><br><br>________________&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;___________________<br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Palembang Souvenir House</div></div></body></html>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = location.reload(false);

          }


        </script>