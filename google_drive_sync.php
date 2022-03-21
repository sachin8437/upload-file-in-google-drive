<?php 
// Include Google drive api handler class 
include_once 'GoogleDriveApi.class.php'; 
     
// Include database configuration file 
require_once 'dbConfig.php'; 
 
$statusMsg = ''; 
$status = 'danger'; 
if(isset($_GET['code'])){ 
    // Initialize Google Drive API class 
    $GoogleDriveApi = new GoogleDriveApi(); 
     
    // Get file reference ID from SESSION 
    $file_id = $_SESSION['last_file_id']; 
 
    if(!empty($file_id)){ 
         
        // Fetch file details from the database 
        $sqlQ = "SELECT * FROM drive_files WHERE id = ?"; 
        $stmt = $db->prepare($sqlQ);  
        $stmt->bind_param("i", $db_file_id); 
        $db_file_id = $file_id; 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $fileData = $result->fetch_assoc(); 
         
        if(!empty($fileData)){ 
            $file_name = $fileData['file_name']; 
            $target_file = 'uploads/'.$file_name; 
            $file_content = file_get_contents($target_file); 
            $mime_type = mime_content_type($target_file); 
             
            // Get the access token 
            if(!empty($_SESSION['google_access_token'])){ 
                $access_token = $_SESSION['google_access_token']; 
            }else{ 
                $data = $GoogleDriveApi->GetAccessToken(GOOGLE_CLIENT_ID, REDIRECT_URI, GOOGLE_CLIENT_SECRET, $_GET['code']); 
                $access_token = $data['access_token']; 
                $_SESSION['google_access_token'] = $access_token; 
            } 
             
            if(!empty($access_token)){ 
                 
                try { 
                    // Upload file to Google drive 
                    $drive_file_id = $GoogleDriveApi->UploadFileToDrive($access_token, $file_content, $mime_type); 
                     
                    if($drive_file_id){ 
                        $file_meta = array( 
                            'name' => basename($file_name) 
                        ); 
                         
                        // Update file metadata in Google drive 
                        $drive_file_meta = $GoogleDriveApi->UpdateFileMeta($access_token, $drive_file_id, $file_meta); 
                         
                        if($drive_file_meta){ 
                            // Update google drive file reference in the database 
                            $sqlQ = "UPDATE drive_files SET google_drive_file_id=? WHERE id=?"; 
                            $stmt = $db->prepare($sqlQ); 
                            $stmt->bind_param("si", $db_drive_file_id, $db_file_id); 
                            $db_drive_file_id = $drive_file_id; 
                            $db_file_id = $file_id; 
                            $update = $stmt->execute(); 
                             
                            unset($_SESSION['last_file_id']); 
                            unset($_SESSION['google_access_token']); 
                             
                            $status = 'success'; 
                            $statusMsg = '<p>File has been uploaded to Google Drive successfully!</p>'; 
                            $statusMsg .= '<p><a href="https://drive.google.com/open?id='.$drive_file_meta['id'].'" target="_blank">'.$drive_file_meta['name'].'</a>'; 
                        } 
                    } 
                } catch(Exception $e) { 
                    $statusMsg = $e->getMessage(); 
                } 
            }else{ 
                $statusMsg = 'Failed to fetch access token!'; 
            } 
        }else{ 
            $statusMsg = 'File data not found!'; 
        } 
    }else{ 
        $statusMsg = 'File reference not found!'; 
    } 
     
    $_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
     
    header("Location: index.php"); 
    exit(); 
} 
?>