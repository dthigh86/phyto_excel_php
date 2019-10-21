<?php include("../phytodb_head.php") ?>
<?php
    // Send to log if no session..
	if(!isset($_SESSION['SugarAuth'])){
		?>
        <script language="javascript" type="text/javascript">
			window.location = "log.php";
		</script>
        <?php
	}
?>



<form action="index.php" method="post" enctype="multipart/form-data">
    Select excel to upload:
    <input type="file" name="file" id="file">
    <input type="submit" value="Upload" name="submit">
</form>



        <footer></footer>

    </body>
</html>
