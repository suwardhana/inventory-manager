
<div class="col-md-12">
  <?php echo $this->session->flashdata('msg'); ?>
  <form action="#" method="post" >
    <table class="table-bordered table">
      <tr>
        <td>Bulan</td>
        <td>
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
          </td>
      </tr>
      <tr>
        <td>Tahun</td>
        <td>
          <select name="tahun" id="" class="form-control">
                
                <option value="2016">2016</option>
                <option value="2017">2017</option>
				<option value="2017">2018</option>
				<option value="2017">2019</option>
				<option value="2017">2020</option>
              </select>
        </td>
      </tr>
      <tr>
        <td>Target Omset</td>
        <td>
          <input type="text" name="t_omset" class="form-control" required>
        </td>
      </tr>
      <td colspan="2">
        <input type="submit" name="submit" class="btn-lg btn btn-primary" value="Submit">
      </td>
    </table>
  </form>
</div>
<div class="col-md-12">
  <div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Omset</h3>
    </div><!-- /.box-header -->
      <div class="box-body">
          <table class="table table-striped">
            <tr>
              <th>No</th>
              <th>Waktu Target</th>
              <th>Target Omset</th>
              <th>Aksi</th>
            </tr>
            <?php $i=1; ?>
            <?php foreach ($data as $waktu): ?>
            <tr>
              <th><?php echo $i; ?></th>
              <th><?php echo TanggalIndo($waktu->date_omset); ?></th>
              <th><?php echo number_format($waktu->t_omset); ?></th>
              <th><a href='#delete_<?php echo $waktu->id_omset ?>'class='btn btn-danger' data-toggle='modal'><i class="fa-trash fa"></i>&nbspDelete</a></th>
            </tr>
            <?php $i++; ?>
            <?php endforeach ?>
          </table>
      </div>
</div>  
</div>
<?php if(!empty($data)){
                        foreach ($data as $v){?>
<div class="modal fade" id="delete_<?php echo $v->id_omset;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <form action="<?php echo site_url('omset/delete_omset');?>" method="post">
            <input type="hidden" value="<?php echo $v->id_omset;?>" name="id_omset">
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