<div class="box box-primary">
  <div class="box-header">
    <h3 class="box-title">Harga Barang</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
   <div class="col-lg-12">    
    <div class="col-md-4">
      
    </div> 
  </div>
  
  <table id="" class="table table-bordered table-hover datatables-example">
    <thead>
      <tr>
        <th style="width: 10px;">No</th>
        <th style="width: 10px;">Foto</th>
        <th style="width: 250px;">Item Name</th>
        <th style="width : 10px;">Satuan</th>
        <th style="width : 10px;">banyak</th>
        <th style="width : 10px;">partai</th>
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
        echo "<td><img src='".base_url()."assets/img/barang/".$val->link_gambar."' class='katalog' ></td>";
        echo "<td>".$val->item_name."</td>";
        echo "<td>".number_format($val->satuan)."</td>";
        echo "<td>".number_format($val->banyak)."</td>";
        echo "<td>".number_format($val->partai)."</td>";
        echo "</tr>";
      }
    }
    ?> 
  </tbody>
</table>
</div><!-- /.box-body -->
<div class="box-footer">
</div>
  </div><!-- /.box -->