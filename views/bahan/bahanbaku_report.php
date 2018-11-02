
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
              <h3 class="box-title">Laporan Bahan Baku</h3>
            </div><!-- /.box-header -->
            <div class="box-body">  
                <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td width="5%">No</td>
					<td>Tujuan</td>
                    <td>Alamat</td>
                    <td>Bentuk Hasil</td>
                    <td>Banyak Bahan</td>
                    <td>Tanggal Kirim</td>   
                    <td>Tanggal Sampai</td>
					<td>Estimasi Jadi</td>
					<td>Jumlah Jadi</td>
					<td>Sisa Bahan</td>
					<?php if(!$ispegawai){?>
                    <td>Delete</td><?php } ?>
                </tr>
              </thead>
              <tbody>              
                  <?php
                  $i=1;
                    if(!empty($isi)){
                        foreach ($isi as $val){
								$nama=explode(',',$val->nama_hasil);
								$banyak=explode(',',$val->banyak);
								$estimasi=explode(',',$val->estimasi);
								if($val->jumlahjadi != null) {$jadi=explode(',',$val->jumlahjadi);}
								if($val->sisa != null){$sisa=explode(',',$val->sisa);}
								$count=count($nama);
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
								echo "<td>".$val->tujuan."</td>";
								echo "<td>".$val->alamat."</td>";
								echo "<td>";
								for($k=0;$k<$count;$k++)
                            {echo $nama[$k]."<br>";}
							echo "</td>";
								echo "<td>";
								for($k=0;$k<$count;$k++)
                            {echo $banyak[$k];echo "<br>";}
							echo "</td>";
							echo "<td>".$val->tanggal."</td>";
								echo "<td>".$val->tglsampai."</td>";
								echo "<td>";
								for($k=0;$k<$count;$k++)
                            {echo $estimasi[$k]."<br>";}
							echo "</td>";
							echo "<td>";if($val->jumlahjadi != null){
								for($k=0;$k<$count;$k++)
                            {echo $jadi[$k]."<br>";}}
							
							echo "</td>";
							echo "<td>";
							if($val->sisa != null){
								for($k=0;$k<$count;$k++)
                            {echo $sisa[$k]."<br>";}}
							echo "</td>";
                                if(!$ispegawai){echo "<td><a href='".site_url('bahan/update')."/".$val->idcatatbahan."'class='btn btn-primary'>Update</button><a href='#delete_".$val->idcatatbahan."'class='btn btn-danger' data-toggle='modal'>Delete</button></td>";} 
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
<div class="modal fade" id="delete_<?php echo $v->idcatatbahan;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <form action="<?php echo site_url('bahan/delete');?>" method="post">
            <input type="hidden" value="<?php echo $v->idcatatbahan;?>" name="id">
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
              "<html><head><title></title></head><body><div class='col-md-6'>  " + 
              divElements + "<div class='col-sm-6'>Keterangan : Barang yang telah dibeli tidak dapat dikembalikan kecuali ada perjanjian<br>Tanda terima,<br><br><br>________________</div><div class='col-sm-4'><br><br>Hormat Kami,<br><br><br>___________________<br>Palembang Souvenir House</div></div></body></html>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = location.reload(false);

    }
</script>