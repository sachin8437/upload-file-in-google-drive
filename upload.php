<?php     
// Include database configuration file 
require_once 'dbConfig.php'; 
 
$statusMsg = $valErr = ''; 
$status = 'danger'; 
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
     
    // Validate form input fields 
    if(empty($_FILES["file"]["name"])){ 
        $valErr .= 'Please select a file to upload.<br/>'; 
    } 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        $targetDir = "uploads/"; 
        $fileName = basename($_FILES["file"]["name"]); 
        $targetFilePath = $targetDir . $fileName; 
        /*  echo $fileName;
		 die; */
        // Upload file to local server 
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){ 
             
            // Insert data into the database 
            $sqlQ = "INSERT INTO drive_files (file_name,created) VALUES (?,NOW())"; 
            $stmt = $db->prepare($sqlQ); 
            $stmt->bind_param("s", $db_file_name); 
            $db_file_name = $fileName; 
            $insert = $stmt->execute(); 
             
            if($insert){ 
                $file_id = $stmt->insert_id; 
                 
                // Store DB reference ID of file in SESSION 
                $_SESSION['last_file_id'] = $file_id; 
                 
                header("Location: $googleOauthURL"); 
                exit(); 
            }else{ 
                $statusMsg = 'Something went wrong, please try again after some time.'; 
            } 
        }else{ 
            $statusMsg = 'File upload failed, please try again after some time.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}else{ 
    $statusMsg = 'Form submission failed!'; 
} 
 
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
header("Location: index.php"); 
exit(); 
?>