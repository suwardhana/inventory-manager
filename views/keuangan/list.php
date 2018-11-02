
  <!--  Notification  -->
        <?php $msg = $this->session->flashdata('msg1'); if((isset($msg)) && (!empty($msg))) { ?>
        <div class="alert alert-danger" >
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <b><?php print_r($msg); ?></b>
        </div>
        <?php } ?>

    <section class="content">
      <div class="row">
        <div class="col-lg-5">
          <!-- general form elements -->     
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">List jenis pengeluaran</h3>
            </div><!-- /.box-header -->
            <div class="box-body">  
                <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td>No</td>
          					<td>Jenis Pengeluaran</td>
                    <?php if(!$ispegawai){?><td>Delete</td><?php } ?>
                </tr>
              </thead>
              <tbody>              
                  <?php
                  $i=1;
                    if(!empty($jenis_keluar)){
                        foreach ($jenis_keluar as $val){
                                echo "<tr>";
                                echo "<td>".$i++."</td>";
								echo "<td>".$val->jenis_keluar."</td>";
                                echo "";       
                                if(!$ispegawai){echo "<td><a href='#delete_".$val->id_jenis."'class='btn btn-danger' data-toggle='modal'>Delete</a></td>"; }
                            echo "</tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
            </div>
			<div class="box-footer">
        <a href="<?php echo site_url('keuangan/tambah_pengeluaran');?>" class="btn btn-primary">Add</a>
        <button class="btn btn-default" onclick="location.reload();">Refresh</button>
    </div>

            
<!--Delete Modal -->
<?php if(!empty($jenis_keluar)){
                        foreach ($jenis_keluar as $v){?>
<div class="modal fade" id="delete_<?php echo $v->id_jenis;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
            <form action="<?php echo site_url('keuangan/delete');?>" method="post">
            <input type="hidden" value="<?php echo $v->id_jenis;?>" name="id">
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