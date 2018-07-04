<?php 
include("config.php"); 

$file 			= $_FILES['file1']['tmp_name'];
$remote_file 	= $_FILES['file1']['name'];

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_username, $ftp_password);

// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}

// close the connection
ftp_close($conn_id);
?>