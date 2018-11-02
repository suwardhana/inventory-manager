<section class="content">
      <div class="row">
	  <div class="col-md-4"></div>
        <div class="col-md-4">
          <!-- general form elements -->     
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Insert Pengeluaran</h3></h3>
            </div><!-- /.box-header -->
                <form method="post" action="<?php echo site_url('keuangan/insert2');?>" id="form">
                        <div class="box-body">
						<strong>Jenis Pengeluaran</strong><select name="jenis_keluar" class="form-control"><?php foreach ($jenis_keluar as $val){ ?><option value="<?php echo $val->id_jenis;?>"><?php echo $val->jenis_keluar;?></option><?php } ?></select><br>
						<strong>Tanggal</strong>
							<div id="datepicker" class="input-group date"  data-auto-close="true" data-date-format="yyyy-mm-dd" data-date-autoclose="true" >
                    <input class="form-control" id="tanggal" name="tanggal" type="text">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
						<strong>Keterangan</strong><input type="text" class="form-control" name="keterangan">
						<strong>Jumlah</strong><input type="text" class="form-control" name="jumlah">
						<button class="btn btn-primary submit">insert</button>
						</div>
						</form>
			</div>	
		</div>
		</div>
	
		</section>