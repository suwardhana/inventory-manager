<script>
  function submit_data()
  {
    var id_barang=$('#id_barang').val();
    var item_name = $("#item_name").val();
    var modal = $("#modal").val();  
    var stok = $("#stok").val(); 
    var satuan = $("#satuan").val();
    var banyak = $("#banyak").val(); 
    var partai = $("#partai").val(); 	
    var jumlahmin = $("#jumlahmin").val(); 
    var gambar = $("#gambar").val(); 
    var submit = $("#form_add").attr('action');   

    $.ajax({
      type: "POST",
      url: submit,
      data: {
        "id_barang":id_barang,
        "item_name":item_name,
        "modal":modal,
        "stok":stok,
        "jumlahmin":jumlahmin,
        "satuan":satuan,
        "banyak":banyak,
        "link_gambar":gambar,
        "partai":partai
      },
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

    $("#item_name").val('');
    $("#modal").val('');
    $("#stok").val('');
    $("#satuan").val('');
    $("#banyak").val('');
    $("#partai").val('');
    $("#jumlahmin").val('');
    $("#id_barang").val('');
    $("#gambar").val('');

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
        $("#satuan").val(obj.satuan);
        $("#banyak").val(obj.banyak);
        $("#gambar").val(obj.gambar);
        $("#partai").val(obj.partai);
        $("#jumlahmin").val(obj.jumlahmin);
        $('#mod_add').modal({
          backdrop: 'static'
        });
        $('#mod_add').modal('show'); 
      },
      error:function(event, textStatus, errorThrown) {
        $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });
  }

  function del_data(id_barang){
    var r=confirm("Are you sure to Delete data ?");
    if (r===true)
    {
      $.ajax({
        type: "POST",
        url: "<?=site_url('ajaxform/submit');?>",
        data: {"id_barang":id_barang,"stat":"delete"},
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
    <h3 class="box-title">Item Details</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
   <div class="col-lg-12">    
    <div class="col-md-8">
      <strong>Cek Produk Terlaris</strong><br><br>
      <form action="#" method="POST">
        <div class="col-md-4">
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
        </div>
        <div class="col-md-4">
          <select name="tahun" id="" class="form-control">
            <option value="2016">2016</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="submit" class="btn btn-primary" name="filter_date" value="Filter">   
        </div>
      </form>
    </div>
    <div class="col-md-4">

    </div> 
  </div>

  <table id="" class="table table-bordered table-hover datatables-example">
    <thead>
      <tr>
        <th style="width: 10px;">No</th>
        <th style="width: 250px;">Item Name</th>
        <th style="width: 10px;">Modal</th> 
        <th style="width : 10px;">Stok</th>
        <th style="width : 10px;">Nilai</th>
        <?php if(!$ispegawai){?>
         <th style="width: 10px;">Edit</th>
         <th style="width: 10px;">Delete</th>
         <?php } ?>
       </tr>
     </thead>
     <tbody>
      <?php
      $i=1;
      if(!empty($tabel)){
       $i=1;$totnilai=0;
       foreach ($tabel as $val){
        echo "<tr>";
        echo "<td>".$i++."</td>";
        echo "<td><a href=".site_url('barang')."/barang_reports/".$val->id_barang.">".$val->item_name."</a></td>";
        echo "<td>".number_format($val->modal)."</td>";
        if($val->jumlah>$val->jumlahmin){
          echo "<td>".$val->jumlah."</td>";}
          else if(($val->jumlah<$val->jumlahmin)&&($val->jumlah>0))echo "<td bgcolor='#dd4b39'>".$val->jumlah."</td>";
          else if ($val->jumlah==0) echo "<td bgcolor='yellow'>Habis</td>";
          else echo  "<td bgcolor='blue'>".$val->jumlah."</td>";
          $nilai = $val->modal * $val->jumlah;
          echo "<td>".number_format($nilai)."</td>";
          $totnilai = $totnilai + $nilai;
          if(!$ispegawai)
            {echo "<td><button data-toggle=\"modal\" data-target=\"#mod_add\" data-backdrop=\"static\" "
          . " class=\"btn btn-default btn-sm btn-block\" onclick=\"set_data(".$val->id_barang.");\">Edit</button></td>";
          echo "<td><button class=\"btn btn-danger btn-sm btn-block\" onclick=\"del_data(".$val->id_barang.");\">Delete</button></td>";}
          echo "</tr>";
        }
      }
      ?> 
    </tbody>
  </table>
  <strong>Total Nilai = <?php echo number_format($totnilai);?></strong>
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
      echo form_open('ajaxform/submit',$attributes); 
      ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="cancel();">&times;</button>
        <h4 class="modal-title" id="myModalLocationLabel">
          <i class="fa fa-fw fa-cloud"></i>
          Item Details
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
            <input type="hidden" id="id_barang" name="id_barang" />
            <div class="col-xs-12">
              <div class="form-group">
                <label for="item_name">Item Name</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-cloud"></i>
                  </div>
                  <input type="text" class="form-control" id="item_name" name="item_name" 
                  placeholder="Item Name" >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Stok</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-briefcase"></i>
                  </div>
                  <input type="text" class="form-control" id="stok" name="stok" 
                  placeholder="Item stok" >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Modal</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" id="modal" name="modal"  >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Satuan</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" id="satuan" name="satuan"  >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Banyak</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" id="banyak" name="banyak"  >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Partai</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-usd"></i>
                  </div>
                  <input type="text" class="form-control" id="partai" name="partai"  >
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label for="rate">Stok Minimal</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-fw fa-gift"></i>
                  </div>
                  <input type="text" class="form-control" id="jumlahmin" name="jumlahmin">
                </div>
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <label>Gambar</label>
                  <input type="text" class="form-control" id="gambar" name="gambar">
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
<div> <b>Keterangan Warna : </b><br>1. Warna merah = Stok di bawah jumlah minimal <br>2. Warna kuning = Stok habis<br>3. Warna biru = Stok sama dengan jumlah minimal</div>