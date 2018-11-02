
<script>
function submit_data()
{
    var id_absen=$('#id_absen').val();
    var tanggal = $("#tanggal").val();
	var nama = $("#nama").val();  
    var keterangan = $("#keterangan").val(); 
    var submit = $("#form_add").attr('action');   

    $.ajax({
        type: "POST",
        url: submit,
        data: {"id_absen":id_absen,"tanggal":tanggal
                ,"nama":nama,"keterangan":keterangan},
        success: function(resp){   
            var obj = jQuery.parseJSON(resp);
            $("#myResponDeptLabel").html(obj.msg);
            if(obj.stat==="1"){
                $('#mod_add').modal('hide');
                location.reload();
            }
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function cancel(){
       
    $("#tanggal").val('');
	$("#nama").val('');
	$("#keterangan").val('');
  
}

function set_data(id_barang){
    $.ajax({
        type: "POST",
        url: "<?=site_url('ajaxform/set_data');?>",
        data: {"id_barang":id_barang},
        success: function(resp){
            var obj = jQuery.parseJSON(resp);
            $("#id_barang").val(obj.id_barang);      
            $("#item_name").val(obj.item_name);
            $("#stok").val(obj.stok);
			$("#modal").val(obj.modal);
			$("#jumlahmin").val(obj.jumlahmin);
            $('#mod_add').modal({
                backdrop: 'static'
              });
            $('#mod_add').modal('show'); 
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message2: '+ textStatus + ' , HTTP Error2: '+errorThrown);
        }
    });
}

function del_data(id_absen){
    var r=confirm("Are you sure to Delete data ?");
    if (r===true)
      {
          $.ajax({
                type: "POST",
                url: "<?=site_url('absen/submit');?>",
                data: {"id_absen":id_absen,"stat":"delete"},
                success: function(resp){
                    var obj = jQuery.parseJSON(resp);
                    alert(obj.msg);
                    if(obj.stat==="1"){
                        location.reload();
                    }
                },
                error:function(event, textStatus, errorThrown) {
                    $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
      }
}
</script>

<div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Catatan Cuti Rekan Kerja</h3>
    </div><!-- /.box-header -->
      <div class="box-body">
	  <div class="col-sm-5">
	  <div align="right" ><a href="<?php echo site_url('absen/insert_peg/');?>" ><button class="btn btn-primary submit">Tambah</button></a></div>
	   <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td style="width: 10px;">No</td>
                    <td style="width: 20px;">Nama</td>
					<td style="width: 10px;">Kontak</td> 
					<td style="width : 10px;">Delete</td>
					</tr>
              </thead>
			  <tbody>
			  <?php
                  $i=1;
                    if(!empty($tabel2)){
					$i=1;
                        foreach ($tabel2 as $val2){
                            echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".$val2->nama."</td>";
								echo "<td>".$val2->kontak."</td>";
								echo "<td><a href=".site_url('absen/delpeg/'.$val2->idpegawai).">
								<button class=\"btn btn-danger btn-sm btn-block\" >Delete</button></a></td>";
                            echo "</tr>";
                        }
                    }
                  ?> 
			  </tbody>
			  </table>
			  </div>
          <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td style="width: 10px;">No</td>
                    <td style="width: 20px;">Hari</td>
					<td style="width: 10px;">Tanggal</td> 
					<td style="width : 10px;">Nama</td>
					<td style="width : 60px;">Keterangan</td>
                    <td style="width: 10px;">Delete</td>
                </tr>
              </thead>
              <tbody>
                  <?php
                  $i=1;
                    if(!empty($tabel)){
					$i=1;
                        foreach ($tabel as $val){
                            echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".hari($val->date)."</td>";
								echo "<td>".TanggalIndo($val->date)."</td>";
								echo "<td>".$val->nama."</td>";
								echo "<td>".$val->keterangan."</td>";
								
                                
                                echo "<td><button class=\"btn btn-danger btn-sm btn-block\" onclick=\"del_data(".$val->id_absen.");\">Delete</button></td>";
                            echo "</tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button data-toggle="modal" data-target="#mod_add" data-backdrop="static" class="btn btn-primary">Add</button>
        <button class="btn btn-default" onclick="location.reload();">Refresh</button>
    </div>
  </div><!-- /.box -->
  
  <div class="modal fade" id="mod_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <?php
            $attributes = array('role' => 'form'
                , 'id' => 'form_add', 'name' => 'form_add');
            echo form_open('absen/submit',$attributes); 
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLocationLabel">
              <i class="fa fa-fw fa-cloud"></i>
              Input Absen
          </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-xs-12">
                    <div id="myResponDeptLabel" class=" animated fadeInDown"></div>
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">  
                    <input type="hidden" id="id_absen" name="id_absen" />
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="item_name">Tanggal</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-cloud"></i>
                            </div>
                            <div id="datepicker" class="input-group date"  data-auto-close="true" data-date-format="yyyy-mm-dd" data-date-autoclose="true" >
                    <input class="form-control" id="tanggal" name="tanggal" type="text">
    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                </div>
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="rate">Nama</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-male"></i>
                            </div>
                            <select class="form-control" name="nama" id="nama">
							<?php
                    if(!empty($tabel2)){
					foreach ($tabel2 as $val2){
                            echo "<option value=\"".$val2->nama."\">".$val2->nama."</option>";
								}
                    }
                  ?>
							</select>
							</div>
                        </div>
                    </div>
					<div class="col-xs-12">
                        <div class="form-group">
                          <label for="rate">Keterangan</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-file-text-o"></i>
                            </div>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"  >
                          </div>
                        </div>
                    </div>
					
                    
                </div>  
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" onclick="submit_data();">Submit</button>
            <button class="btn btn-default" type="button" data-dismiss="modal" aria-hidden="true" onclick="cancel();">Cancel</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
</div>