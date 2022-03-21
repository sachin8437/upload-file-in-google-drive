<?php 
// Include configuration file 
include_once 'config.php'; 
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
     
    unset($_SESSION['status_response']); 
} 
?>


 <!DOCTYPE html>
 <html lang="en-US">
 <head>
	<title>
		Upload file to Google Drive
	</title>
	<meta charset="utf-8">
 </head>
 <body>
 <h1>UPLOAD FILE  To GOOGLE DRIVE</h1>
 
<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <div class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>
 <form method="post" action="upload.php" class="form" enctype="multipart/form-data">
	<label>File</label>
	<input type="file" name="file" class="form-control">
	<input type="submit" class="form-control btn-primary" name="submit" value="Upload">
 </form>
 </body>
 </html>