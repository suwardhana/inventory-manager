
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
              <h3 class="box-title">laporan Barang</h3>
            </div><!-- /.box-header -->
            <div class="box-body">  
			<strong><?php 
			 foreach ($barang as $name){echo $name->item_name;
			 $nilai = $name->modal * $name->jumlah;
			 echo "<br>bernilai : ";
			 echo number_format($nilai);
			 echo "<br> Stok Sekarang : ";
			 echo $name->jumlah;
			 }?></strong>
                <table class="table table-bordered table-hover datatables-example">
              <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Banyak</th>
					<th>Nilai</th>
                    <th>Delete</th>
                </tr>
              </thead>
              <tbody>              
                  <?php
                  $i=1;
                    if(!empty($invoice)){
                        foreach ($invoice as $val){
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".$val->tanggal."</td>";
                                if(($val->masuk)==0)echo "<td><span class='fa fa-arrow-up'></span> keluar</td>"; else echo "<td><span class='fa fa-arrow-down'></span> masuk</td>";
								echo "<td>".$val->jumlah."</td>";
								foreach ($barang as $name){
									echo "<td>".number_format($name->modal*$val->jumlah)."</td>";
								}
								
                                echo "<td><a href='#delete_".$val->id."'class='btn btn-danger' data-toggle='modal'>Delete</button></td>"; 
                            echo "</tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
            </div>

           


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
            <form action="<?php echo site_url('barang/delete_hbarang');?>" method="post">
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