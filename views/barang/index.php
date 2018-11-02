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
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Pemasukan Barang</h3>
            </div><!-- /.box-header -->
            <form method="post" action="<?php echo site_url('barang/insert_barang');?>" id="form">
              <div class="box-body">
               
                <table class="table datatables-example">
                  <tr>
                    <th>kode</th>
                    <th>Nama Item</th>
                    <th>Stok</th>
                    <th>Jumlah Masuk</th>                   
                    <th></th>
                  </tr>
                  <tbody>
                   <tr><td width="10px"><input class="form-control" type="text" name="idbarang[]" id="kode1"></td>
                    <td><input type="text" name="item[]" class="form-control" id="item1" Placeholder="Enter Item name here ">
                      <div id="item_valid1"></div></td>

                      <td><input type="text" name="stok[]" id="stok1" disabled class="form-control"></td>

                      <td><input type="text" name="quantity[]" id="quantity1" class="form-control" Placeholder="Enter quantity here ">
                        <div id="quantity_valid1"></div></td> 


                        <td align="right"><button type="button" class="btn btn-danger remove"> Remove</button type="button"></td>
                        </tr>
                      </tbody>
                      <tbody id="append"></tbody>
                    </table> 
                    <input type="hidden" value="1" id="hide">
                    <div class="pull-right">
                      <button type="button" class="btn btn-primary add" >+Add Row</button type="button">   
                      </div>
                      <br><br>
                      
                      
                    </div><!-- /.box-body -->
                  </form>
                </div><!-- /.box -->
              </div>
            </div>   <!-- /.row -->
          </section><!-- /.content -->

          <div align="center">
            <button class="btn btn-primary submit">Input</button>
          </div>

          <script type="text/javascript">
            $(document).ready(function(){

              
    //Append new rows

    $('.add').click(function(){
      var start=$('#hide').val();
      var total=Number(start)+1;
      $('#hide').val(total);
      var tbody=$('#append');
      $('<tr><td width="10px"><input type="text" name="idbarang[]" class="form-control" id="kode'+total+'"></td><td><input type="text" name="item[]" class="form-control" id="item'+total+'" Placeholder="Enter Item name here "><div id="item_valid'+total+'"></td><td><input type="text" name="stok[]" id="stok'+total+'" class="form-control" disabled></td><td><input type="text" name="quantity[]" id="quantity'+total+'" class="form-control" Placeholder="Enter quantity here "><div id="quantity_valid'+total+'"></div></td><td align="right"><button type="button" class="btn btn-danger remove">Remove</button type="button"></td></tr>').appendTo(tbody);

      
      /*Remove the rows */

      $('.remove').click(function(){     
       $(this).parents('tr').remove(); 
     });


      $( "#item"+total+"" ).autocomplete({

        source: function(request, response) {
          $.ajax({ 
            url: "<?php echo site_url('ajaxform/autocomplete'); ?>",
            data: { name: $("#item"+total+"").val()},
            dataType: "json",
            type: "POST",
            success: function(data){              
             //alert(data);
             response(data);
           }    
         });
        },
      });

      /*Ajax content fills */
      $('#item'+total+'').blur(function(){
        $.post('<?php echo site_url('ajaxform/get_contents');?>',{name:$('#item'+total+'').val()},function(res){
          var obj=jQuery.parseJSON(res);
          $('#stok'+total+'').val(obj.stok);
          $('#kode'+total+'').val(obj.id_barang);
          $('#quantity'+total+'').focus();
        });
      });  


      
    });

    /*Submit ther form */
    $('.submit').click(function(){

      for(var i=1;i<=$('#hide').val();i++)
      {
        var item=$('#item'+i+'').val();
        var stok=$('#stok'+i+'').val();
        var quantity=$('#quantity'+i+'').val();
        

        if(item=='')
        {
          $('#item'+i+'').focus();       

          $('#item_valid'+i+'').html('<div><font color="red">Enter The Item name</font><div>');
          $('#item'+i+'').css("border-color", "red");  
          $('#item'+i+'').focus();
          $('#item'+i+'').keyup(function(){      
            $(this).css("border-color", "green");
            
          });
          return false;
        }
        else
        {
          $('#item_valid'+i+'').hide();$('#rate_valid'+i+'').hide();$('#tax_valid'+i+'').hide();
        }
        
        
        if(quantity=='')
        {
          $('#quantity'+i+'').focus();       

          $('#quantity_valid'+i+'').html('<div><font color="red">Enter The Quantity</font><div>');
          $('#quantity'+i+'').css("border-color", "red");  
          $('#quantity'+i+'').focus();
          $('#quantity'+i+'').keyup(function(){      
            $(this).css("border-color", "green");
            
          });
          return false;
        }
        else
        {
         $('#quantity_valid'+i+'').hide();
       }
       
     }
     $('#form').submit();

   });
//item name for first row

$( "#item1" ).autocomplete({

  source: function(request, response) {
    $.ajax({ 
      url: "<?php echo site_url('ajaxform/autocomplete'); ?>",
      data: { name: $("#item1").val()},
      dataType: "json",
      type: "POST",
      success: function(data){              
             //alert(data);
             response(data);
           }    
         });
  },
});

    // get matched contents to text box
    
    $('#item1').blur(function(){
      $.post('<?php echo site_url('ajaxform/get_contents');?>',{name:$("#item1").val()},function(res){
        var obj=jQuery.parseJSON(res);
        $('#stok1').val(obj.stok);
        $('#kode1').val(obj.id_barang);
        $('#quantity1').focus();
      });
    });  

    
  });
</script>