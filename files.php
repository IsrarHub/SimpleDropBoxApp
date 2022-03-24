<?php           
           include 'connectDropBox.php';
$authurl=$authHelper->getAuthUrl($callbackUrl);
          
if(!isset($_SESSION['name'])){
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DropBox</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['name']?></a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <?php if(empty($_SESSION['token'])){?>
          <li class="nav-item">
<?php

echo "<a class='nav-link' href='" . $authurl . "'>Log in with Dropbox</a>";
?>
            <!-- <a href="connectDropBox.php" class='nav-link'> -->
            <i class="fas fa-link nav-icon"></i>
              <p>
              </p>
            </a>
          </li>
          <?php }else{?>
          <li class="nav-item">
            <a href="disconnectDropBox.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Disconnect DropBOx
              </p>
            </a>  
          </li>
          <?php }?>
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Folders
              </p>
            </a>  
          </li>
          <li class="nav-item">
            <a href="files.php" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Files
              </p>
            </a>  
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-12">
            <h1 class="m-0 text-center">DropBox</h1>
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#uploadFile">
              Upload file
            </button>
          </div><!-- /.col -->
          
      <div class="col-md-12">
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">All files</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" style="width: 100;">
                  <thead>
                    <tr>
                      <th>File Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody id="ta">
                   <?php 
                   include "dbcon.php";
                   $query="SELECT * FROM files";
                   $result=mysqli_query($conn,$query);
                   if(mysqli_num_rows($result)>0){
                   while($row =mysqli_fetch_assoc($result) ){
                     ?>
            <tr>
              <td><?= $row['file_name']?></td>
              <td><button type="button" class="btn btn-success editData mr-2" id='<?php echo $row['file_name'] ?>'>Edit </button><button type="button" class="btn btn-danger delete" id='<?php echo $row['file_name'] ?>'>Delete </button></td>
            </tr>
                   <?php }

                   }
                   ?>
                    
                  </tbody>
                </table>
              </div>
              </div>
            </div>
            <!-- /.card -->





        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Button trigger modal -->



<div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="uploadFileLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadFileLabel">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=""  id='file' >
      <div class="modal-body">
       
        <div class="form-group">
                    <input type="file" name="load" class="form-control" class="form-control" required>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="upl">upload</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editFile" tabindex="-1" role="dialog" aria-labelledby="editFileLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFileLabel">Edit File Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=""  id='editName' >
      <div class="modal-body"> 
        <div class="form-group">
          <input type="hidden" id="id" name="id">
          <input type="text" name="oldname" id="old">
                    <input type="text" name="load" id="fi" class="form-control" class="form-control" required>
                  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="filechange">update</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<script>



   $('#file').submit(function(e){
   e.preventDefault();
   var form=this;
   $.ajax({
    url:'uploadFile.php',
    method:'post',
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    success:function(data){
      var html='<tr>';
        html+='<td>' + data.filename+'</td>';
        html+='<td><button type="button" class="btn btn-success editData mr-2" id='+data.filename+'>Edit </button> <button type="button" class="btn btn-danger delete" id='+data.filename+'>Delete </button></td></tr>';
        $('#ta').append(html);
      $("#uploadFile").modal('hide');
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Uploaded',
        body: 'File has been uploaded.'
      });
    
    }
   });  
   });

   $(document).on("click",".delete",function(e){
     e.preventDefault();
     var name=$(this).attr("id");
     var tr=$(this).closest("tr");

     $.ajax({
      url:"deleteFiles.php",
      method:"POST",
      data:{
      name:name
      },
      success: function(data){
          tr.fadeOut(1200,function(){
           tr.remove();
          });
          $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Deleted',
        body: 'File has been Deleted.'
      });
      }
     });
   });

   $(document).on("click",".editData",function(e){
     e.preventDefault();
     var name=$(this).attr("id");
    //  var tr=$(this).closest("tr");

     $.ajax({
      url:"getFileDetails.php",
      method:"POST",
      data:{
      name:name
      },
      success: function(data){
        var userData=JSON.parse(data);  
        $('#id').val(userData.file_id);
       $('#fi').val(userData.file_name);
       $('#old').val(userData.file_name);
       $('#editFile').modal('show');
      }
     });
   });


   $('#editName').submit(function(e){
   e.preventDefault();
   var form=this;
   $.ajax({
    url:'updateFile.php',
    method:'post',
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    success:function(data){
      console.log(data);
      $("#editFile").modal('hide');
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'update',
        body: 'File name has been updated.'
      });
    }
   });  
   });
   

</script>

</body>
</html>
