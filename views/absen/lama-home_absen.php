    <section class="content">
      <div class="row">
        <div class="col-lg-12">

<div class="col-md-12">
   <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"><b>kehadiran rekan kerja</b><br><br> <b>Bulan : <?php echo date("m"); ?></b></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <form action="" method="post">  
                <table class="table table-bordered table-striped">
                  <tr>
                    <th rowspan="2"><b>NAMA </b></th>
                    <th colspan="<?php echo $tgl_akhir; ?>"><b><center>TANGGAL</center></b></th>
                  </tr>
				<input type="hidden" name="tglakhir" value="<?php echo $tgl_akhir;?>"/>
                  <tr>
                      <?php for($i=1;$i<=$tgl_akhir;$i++): ?>
                        <th>
                            <?php echo $i; ?>
                        </th>     
                      <?php endfor ?>
                  </tr>
                  <tr>
                      <th>Adit</th>
					  
                       <?php for($i=1;$i<=$tgl_akhir;$i++): 
						$date_absen=date("Y-m");
						$hari = $date_absen.'-'.$i;
					    $this->db->where('date_absen',$hari);
						$cek = $this->db->get('absen')->row();
						if($cek->adit==1){$haha = true;}else $haha = false;
					   ?>
                        <td>
                            <input type="checkbox" name="1date<?php echo $i;?>" <?php if($haha) echo "checked";?> value="1" />
                        </td>     
                      <?php endfor ?>

                  </tr>
				  <tr>
                      <th>Adit</th>
					  
                       <?php for($i=1;$i<=$tgl_akhir;$i++): 
						$date_absen=date("Y-m");
						$hari = $date_absen.'-'.$i;
					    $this->db->where('date_absen',$hari);
						$cek = $this->db->get('absen')->row();
						if($cek->agus==1){$haha = true;}else $haha = false;
					   ?>
                        <td>
                            <input type="checkbox" name="2date<?php echo $i;?>" <?php if($haha) echo "checked";?> value="1" />
                        </td>     
                      <?php endfor ?>

                  </tr>
					<tr><td><input type="submit" value="Simpan" class="btn btn-primary" name="submit"></td></tr>

                                  
                </table>
                </form>
            </div>
          </div>
           </div>
</div>


</div>
</div>
</div>


