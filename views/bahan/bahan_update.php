<section class="content">
      <div class="row">
	  <div class="col-md-4"></div>
        <div class="col-md-4">
          <!-- general form elements -->     
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Update Aktivitas Bahan Baku</h3>
            </div><!-- /.box-header -->
                <form method="post" action="<?php echo site_url('bahan/update2');?>" id="form">
                        <div class="box-body">
						<strong>Tanggal Sampai</strong><div id="datepicker" class="input-group date"  data-auto-close="true" data-date-format="yyyy-mm-dd" data-date-autoclose="true" >
                    <input class="form-control" id="tanggal" name="tglsampai" type="text">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div><br>
				<?php
                      if(!empty($isi)){
                        foreach ($isi as $val){
						$nama=explode(',',$val->nama_hasil);
						$count=count($nama);
						?>
						<input type="hidden" name="id" value="<?php echo $val->idcatatbahan;?>"/>
						<?php 
						for($k=0;$k<$count;$k++)
                            { ?>
						<strong>Jumlah Jadi <?php echo $nama[$k];?></strong><input class="form-control" type="text" name="jumlah[]"/>
						<strong>Sisa Bahan</strong><input class="form-control" type="text" name="sisa[]"/> <br>
						<?php } } } ?><button class="btn btn-primary submit">insert</button>
						</div>
						</form>
			</div>	
		</div>
		</div>
	
		</section>
	