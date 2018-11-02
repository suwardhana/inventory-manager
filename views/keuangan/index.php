 <!-- Success Notification  -->
<?php 
foreach($css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
  <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
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
              <h3 class="box-title">Pencatatan Uang Keluar</h3>
            </div><!-- /.box-header -->
                        <div class="box-body">
							          <div>
    <?php echo $output; ?>
    </div>
                
          </div><!-- /.box-body -->
         
      </div><!-- /.box -->
    </div></div>
  </div>   <!-- /.row -->
</section><!-- /.content -->