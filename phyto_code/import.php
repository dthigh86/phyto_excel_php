<?php include("phytodb_head.php") ?>
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

<?php

?>

</head>
<body>

<div class="pdb_fixedw">
        
        
    <div class="memberspane">
        <h3>Phyto DB Excel Import</h3>
        <p>Import data from your completed Excel workbook. Please utilize the appropriate formatted workbook.</p>
        <p><a href="import/Phyto_DB_Workbook_For_Import.xlsx">Download Formatted Excel Workbook</a></p>
        <?php if( $_GET["msg"] == "success" ){ echo '<p class="success">Your data has been added.</p>'; } ?>
        <hr>
        <form class="uk-form" action="import/index.php" name="dbimport" id="dbimport" method="post" enctype="multipart/form-data" onsubmit="return verify_attachment();">
        	
            <p>Select excel to upload:</p>
            <p>
            <input type="file" name="file" id="file">
            </p>
            
           <p>
            <input type="hidden" name="haspost" id="haspost" value="commit"/>
            </p>
            <br>
            
            <p><button class="uk-button"><i class="uk-icon-cloud-upload"></i> Upload Data</button></p>
        </form>

    </div>
      

</div>

<!-- .end body inc -->
        <footer></footer>

    </body>
</html>
