<?php    
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Export Record CSV
 
*/

// Config
//include '../app_config.php';

$DB_host = "localhost";
$DB_name = "phyto_db";
$DB_user = "phytoclient";
$DB_pass = "5nMGR?kd?K?";
/* dev */
//$DB_user = "root";
//$DB_pass = "root";

$csv_DB = mysql_connect($DB_host,$DB_user,$DB_pass)
	or die("Unable to connect to MySQL");
$csv_DB_selected = mysql_select_db($DB_name,$csv_DB) 
  or die("Could not select database table.");

// **************************************** //

    // filename for export
    $csv_fileName = 'phyto_export_'.date('Y-m-d').'.csv';

    // output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$csv_fileName);

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // IF ALL OR SINGLE PEST RECORD
    $pullAllSql = "SELECT rid, com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range FROM phyto_pest_info Order By rid Desc";
    $singlePest = $_GET["sp"];
    if($singlePest){
        $pullAllSql = "SELECT rid, com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range FROM phyto_pest_info Where rid = ".$singlePest." Order By rid Desc";
    }
        
    fputcsv($output, array('', 'Common Name', 'Scientific Name', 'Acrynom', 'Type', 'Other Names', 'Distribution', 'US Distribution', 'Countries Listing Pest', 'Other', 'Host Range'));

    $PestRows = mysql_query($pullAllSql);
    //$foundrow = mysql_fetch_array($PestRows);
    while ($pestrow = mysql_fetch_assoc($PestRows)){

        $thisrowID = $pestrow["rid"];
        fputcsv($output, $pestrow);

        fputcsv($output, array(''));   // Blank Line
        fputcsv($output, array('Known Hosts'));   // Second Title
        fputcsv($output, array('Hosts/Crop Infected Scientific Name', 'Hosts/Crop Infected Crop', 'Seed Information Pathway', 'Seed Information References', 'Seed Information Comments', 'Detection In Seed Test', 'Detection In Seed Type', 'Detection In Seed Reference', 'Detection In Seed Comments', 'Risk Mitigation Type', 'Risk Mitigation References', 'Risk Mitigation Comments'));

        $hostRowsSQL = "SELECT sci_name, crop, seed_pathway, seed_ref, seed_comments, seed_detect_test, seed_detect_type, seed_detect_ref, seed_detect_comments, risk_mit_type, risk_mit_ref, risk_mit_comments FROM phyto_pest_hosts_crops Where pest_id = ".$thisrowID." Order By rid Desc";
  
        $HostRows = mysql_query($hostRowsSQL);
        while ($hostrow = mysql_fetch_assoc($HostRows)) {

             fputcsv($output, $hostrow);
            
        }
        
        fputcsv($output, array('',''));   // Blank Lines
        
    }


?>  