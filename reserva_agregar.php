  <!DOCTYPE html>
  <html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
      
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <title>Login - <?php include('dist/includes/dbcon.php');?></title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.5 -->
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      
      <!-- Font Awesome -->
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
      <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
    <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </head>
  <body>


<center>     


          <form class="form-horizontal" method="post" action="usuario_cliente_add.php" enctype='multipart/form-data'>





                          <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" ></label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-1 btn-print">
                        <div class="form-group">

                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

                     <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Foto</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
              <input type="file" class="form-control" id="imagen" name="imagen"  >
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

                     <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Nombre</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">

                            <input type="text" class="form-control pull-right" id="date" name="nombre" required >
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>
         
                            <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Apellido</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
                            <input type="text" class="form-control pull-right" id="date" name="apellido" required >
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>


   <div class="row">
    
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Usuario</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
                            <input type="text" class="form-control pull-right" id="usuario" name="usuario"  placeholder="usuario" required>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

   <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Contraseña</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
                            <input type="password" class="form-control pull-right" id="date" name="password" placeholder="password " required>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

   <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Repita contraseña</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
  <input type="password" class="form-control pull-right" id="password2" name="password2" placeholder="password " required>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>



   <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Telefono</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
              <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono"  required>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>
                       <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" >Correo</label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-4 btn-print">
                        <div class="form-group">
              <input type="text" class="form-control" id="correo" name="correo" placeholder="correo"  required>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

   <div class="row">
                      <div class="col-md-3 btn-print">
                        <div class="form-group">
                          <label for="date" ></label>
                   
                        </div><!-- /.form group -->
                      </div>
                         <div class="col-md-1 btn-print">
                        <div class="form-group">
          <button type="submit" class="btn btn-primary">REGISTRAR</button>

                        </div>
                      </div>
                                          <div class="col-md-1 btn-print">
                        <div class="form-group">

                     <a class="btn btn-warning btn-print" href="index.php"    role="button">Regresar</a>
                        </div>
                      </div>
                             <div class="col-md-4 btn-print">
                  
                      </div>
                      </div>

               


               
                   
  
                










                <div class="modal-footer">


                </div>
          </form>


</center>

 
         
     
  <!-- jQuery 2.1.4 -->
      <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
      <!-- Bootstrap 3.3.5 -->
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <!-- SlimScroll -->
      <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <!-- FastClick -->
      <script src="plugins/fastclick/fastclick.min.js"></script>
      <!-- AdminLTE App -->
      <script src="dist/js/app.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="dist/js/demo.js"></script>



    </body>



  </html>
