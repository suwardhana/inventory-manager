 <!-- Success Notification  -->

        <?php 
        $msg = $this->session->flashdata('msg'); if((isset($msg)) && (!empty($msg))) { ?>
        <div class="alert alert-success" >
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <b><?php print_r($msg); ?></b>
        </div>
        <?php } ?>
        
  <!-- Failure Notification  -->
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
          <div > 
		  <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pencatatan Bahan Baku Keluar</h3>
            </div><!-- /.box-header -->
                <form method="post" action="<?php echo site_url('bahan/insert');?>" id="form">
                        <div class="box-body">
							<div class="col-md-3">
							<strong>Tujuan Pengiriman</strong>
							<input type="text" name="nama" class="form-control" required Placeholder="">
							</div>
							<div class="col-md-3">
							<strong>Alamat Pengiriman</strong>
							<input type="text" name="alamat" class="form-control" required Placeholder="">
							</div>
							<div class="col-md-3">
							<strong>Tanggal Pengiriman</strong>
							<div id="datepicker" class="input-group date"  data-auto-close="true" data-date-format="yyyy-mm-dd" data-date-autoclose="true" >
                    <input class="form-control" id="tanggal" name="tanggal" type="text">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div></div>
							
                            <table class="table">
                                <tr>
								  <th>Hasil Olahan</th>
                                  <th>Banyak Bahan</th>
								  <th>Estimasi</th>
								  <th></th>
                              </tr>
                              <tbody>
                               <tr><td><input class="form-control" type="text" name="hasil[]" ></td>
                                  <td><input type="text" name="banyak[]" class="form-control" ></td>
                                  <td><input type="text" name="estimasi[]" class="form-control" ></td>
								  
                                  <td align="right"><button type="button" class="btn btn-danger remove"> Remove</button type="button"></td>
                              </tr>
                              </tbody>
                              <tbody id="append"></tbody>
                        </table> 
              <input type="hidden" value="1" id="hide">
              <div class="pull-right">
              <button type="button" class="btn btn-primary add" >+Add Row</button type="button">   
              </div>              
                
          </div><!-- /.box-body -->
          </form>
      </div><!-- /.box -->
    </div></div>
  </div>   <!-- /.row -->
</section><!-- /.content -->

      <div align="center">
        <button class="btn btn-primary submit">Submit</button>
      </div>

<script type="text/javascript">
  $(document).ready(function(){

        
    //Append new rows

    $('.add').click(function(){
        var start=$('#hide').val();
        var total=Number(start)+1;
        $('#hide').val(total);
        var tbody=$('#append');
        $('<tr><td><input class="form-control" type="text" name="hasil[]" ></td><td><input type="text" name="banyak[]" class="form-control" ></td><td><input type="text" name="estimasi[]" class="form-control" ></td><td align="right"><button type="button" class="btn btn-danger remove"> Remove</button type="button"></td></tr>').appendTo(tbody);

   
    /*Remove the rows */

    $('.remove').click(function(){     
       $(this).parents('tr').remove(); 
       });

 });

/*Submit ther form */
      $('.submit').click(function(){
      $('#form').submit();

      });
  });
</script>