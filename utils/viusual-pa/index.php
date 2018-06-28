<html>
<body>

<?php if ($_SERVER['REQUEST_METHOD'] == 'GET') { ?>

        <form method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>"
        enctype="multipart/form-data">
        <input type="file" name="doc"/>
        <input type="submit" value="Send File"/>
        </form>

<?php } else {
		if (isset($_FILES['doc']) && ($_FILES['doc']['error'] == UPLOAD_ERR_OK)) {
			$xml = simplexml_load_file($_FILES['doc']['tmp_name']);                        
		} else {
                        print "No valid file uploaded.";
                }
        }
?>

</body>
</html>