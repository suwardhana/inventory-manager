<div class="col-md-6 col-md-offset-3">         
 <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Login Area</h3>
            </div><!-- /.box-header -->
            <div class="box-body">  
                <?php echo $this->session->flashdata('pesan');?>
                <form action="" method="POST">
                  <table class="table">
                    <tr>
                      <td>Username</td>
                      <td><input type="text" name="username" class="form-control"></td>
                    </tr>
                    <tr>
                      <td>Password</td>
                      <td><input type="password" name="password" class="form-control"></td>
                    </tr>
                  </table>
                  <input type="submit" name="submit" value="Submit"  class="btn btn-lg btn-primary">
                </form>
            </div>
          </div>
           </div>
