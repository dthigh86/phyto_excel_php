<?php

require_once "autoload.php";

function implodeAndQuote($arr)
{
	foreach ($arr as $index => $value) {
		$val[] = "'".$value."'";
	}
	return implode(",", $val);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	try {

		$target_path = "excels/" . basename( $_FILES["file"]["name"] );

		if ( move_uploaded_file($_FILES['file']['tmp_name'], $target_path) ) {

			$objPHPE 	= PHPExcel_IOFactory::load($target_path);
			$sheetData 	= $objPHPE->getSheetByName("Pests")->toArray(null, true, true, false);
			$database 	= new Db();
			$database->connect();

			foreach ($sheetData as $index => $row) {
				if ($index == 0) { continue; }
				$values = array();
				$sql = "INSERT INTO phyto_pest_info
						(`pest_id`, `img_url`, `sci_name`, `acrynom`, `type`, `other_names`, `dist`, `us_dist`, `countries`, `other`, `host_range`)
						VALUES (".implodeAndQuote($row).")";
				$database->query($sql);
			}

			$sheetData = $objPHPE->getSheetByName("Hosts")->toArray(null, true, true, false);

			foreach ($sheetData as $index => $row) {
				if ($index == 0) { continue; }
				$id = $database->select("SELECT rid from phyto_pest_info where pest_id = '".$row['0']."'")[0]['rid'];
				$values = $row;
				$values[0] = $id;
				$sql = "INSERT INTO phyto_pest_hosts_crops
						(`pest_id`, `sci_name`, `crop`, `seed_pathway`, `seed_ref`, `seed_comments`, `seed_detect_test`, `seed_detect_type`, `seed_detect_ref`, `seed_detect_comments`, `risk_mit_type`, `risk_mit_ref`, `risk_mit_comments`, `rec_health_test`)
						VALUES (".implodeAndQuote($values).")";
				$database->query($sql);
			}
		}

		echo "upload_success";

	} catch (Exception $e) {
		die("upload_fail");
	}

} else {

	die("access_denied");

}


