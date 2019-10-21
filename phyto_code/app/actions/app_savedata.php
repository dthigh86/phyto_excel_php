<?php
session_start();
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Save Posted Data From Card
 
*/

// Config
include '../app_config.php';

// **************************************** //

    
if (!empty($_POST)) {

    // Is this pest card or host card?
    $forCard = $_POST['form_data_card'];
    $recordID = $_POST['form_data_card_val'];
    $dataAction = $_POST['form_data_commit'];   // a = add new, e = edit/update, r = delete
    
    // Actions for pest card
    if( $forCard == 'pest_card'){
        // For pests DB table
        //$insertTable = 'phyto_pest_info';
        // Build SQL HERE
        $com_name = trim($_POST['com_name']);
        $sci_name = trim($_POST['sci_name']);
        $acrynom = trim($_POST['acrynom']);
        $type = trim($_POST['type']);
        $other_names = trim($_POST['other_names']);
        $dist = trim($_POST['dist']);
        $us_dist = trim($_POST['us_dist']);
        $countries = trim($_POST['countries']);
        $other = trim($_POST['other']);
        $host_range = trim($_POST['host_range']);
        
        
        // Add SQL by default
        //$sql_str = "Insert into ".$insertTable." (com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range) Values ('".$com_name."', '".$sci_name."', '".$acrynom."', '".$type."', '".$other_names."', '".$dist."', '".$us_dist."', '".$countries."', '".$other."', '".$host_range."')";
        
        
    
            //$stmt->execute();
        
        
        
        if($dataAction == 'e'){
        
        //$sql_str = "Update phyto_pest_info Set com_name = '".$com_name."', sci_name = '".$sci_name."', acrynom = '".$acrynom."', type = '".$type."', other_names = '".$other_names."', dist = '".$dist."', us_dist = '".$us_dist."', countries = '".$countries."', other='".$other."', host_range = '".$host_range."', review_dt = NOW() Where rid = ".$recordID."";
            
            $sql_str = "Update phyto_pest_info Set com_name = ?, sci_name = ?, acrynom = ?, type = ?, other_names = ?, dist = ?, us_dist = ?, countries = ?, other = ?, host_range = ? Where rid = ?";
            if( $_SESSION['SugarAuth'] == 'master' ){ 
            $sql_str = "Update phyto_pest_info Set com_name = ?, sci_name = ?, acrynom = ?, type = ?, other_names = ?, dist = ?, us_dist = ?, countries = ?, other = ?, host_range = ?, review_dt = NOW() Where rid = ?";
            }
            
            $stmt = $app_DB->prepare($sql_str);
            $stmt->bind_param('ssssssssssi', $com_name, $sci_name, $acrynom, $type, $other_names, $dist, $us_dist, $countries, $other, $host_range, $recordID);
            $stmt->execute();
            
        } else {
            
            $sql_str = "Insert into phyto_pest_info (com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range) Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        
            $stmt = $app_DB->prepare($sql_str);
            $stmt->bind_param('ssssssssss', $com_name, $sci_name, $acrynom, $type, $other_names, $dist, $us_dist, $countries, $other, $host_range);
            $stmt->execute();
            
        }
               
    }
    
    
    
    
    
    
    // Actions for host card
    if( $forCard == 'host_card'){
        // For hosts DB table
        $insertTable = 'phyto_pest_hosts_crops';
        // Build SQL HERE
        //$rID_Host = $rowHosts{'rid'};
        //$pest_id = $rowHosts{'pest_id'};
        $pest_id = $_POST['form_data_parent_card_val'];
        $sci_name = trim($_POST['sci_name']);
        $crop = trim($_POST['host_crop']);
        $seed_pathway = trim($_POST['host_seed_pathway']);
        $seed_ref = trim($_POST['host_seed_ref']);
        $seed_comments = trim($_POST['host_seed_comments']);
        $seed_detect_test = trim($_POST['host_seed_detect_test']);
        $seed_detect_type = trim($_POST['host_seed_detect_type']);
        $seed_detect_ref = trim($_POST['host_seed_detect_ref']);
        $seed_detect_comments = trim($_POST['host_seed_detect_comments']);
        $risk_mit_type = trim($_POST['host_risk_mit_type']);
        $risk_mit_ref = trim($_POST['host_risk_mit_ref']);
        $risk_mit_comments = trim($_POST['host_risk_mit_comments']);
        $rec_health_test = trim($_POST['host_rec_health_test']);
        
        // Add default
        /*$sql_str = "Insert into ".$insertTable." (pest_id, sci_name, crop, seed_pathway, seed_ref, seed_comments, seed_detect_type, seed_detect_test, seed_detect_ref, seed_detect_comments, risk_mit_type, risk_mit_ref, risk_mit_comments, rec_health_test) Values ('".$pest_id."', '".$sci_name."', '".$crop."', '".$seed_pathway."', '".$seed_ref."', '".$seed_comments."', '".$seed_detect_type."', '".$seed_detect_test."', '".$seed_detect_ref."', '".$seed_detect_comments."', '".$risk_mit_type."', '".$risk_mit_ref."', '".$risk_mit_comments."','".$rec_health_test."')";*/
        
        if($dataAction == 'e'){
            
            // Update
            $sql_str = "Update phyto_pest_hosts_crops Set sci_name = ?, crop = ?, seed_pathway = ?, seed_ref = ?, seed_comments = ?, seed_detect_type = ?, seed_detect_test = ?, seed_detect_ref = ?, seed_detect_comments = ?, risk_mit_type = ?, risk_mit_ref = ?, risk_mit_comments = ?, rec_health_test = ? Where rid = ?";
            
            $stmt = $app_DB->prepare($sql_str);
            $stmt->bind_param('sssssssssssssi', $sci_name, $crop, $seed_pathway, $seed_ref, $seed_comments, $seed_detect_type, $seed_detect_test, $seed_detect_ref, $seed_detect_comments, $risk_mit_type, $risk_mit_ref, $risk_mit_comments, $rec_health_test, $recordID);
            $stmt->execute();
            
            
        } else {
            
            // Add default
        $sql_str = "Insert into phyto_pest_hosts_crops (pest_id, sci_name, crop, seed_pathway, seed_ref, seed_comments, seed_detect_type, seed_detect_test, seed_detect_ref, seed_detect_comments, risk_mit_type, risk_mit_ref, risk_mit_comments, rec_health_test) Values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $app_DB->prepare($sql_str);
            $stmt->bind_param('isssssssssssss', $pest_id, $sci_name, $crop, $seed_pathway, $seed_ref, $seed_comments, $seed_detect_type, $seed_detect_test, $seed_detect_ref, $seed_detect_comments, $risk_mit_type, $risk_mit_ref, $risk_mit_comments, $rec_health_test);
            $stmt->execute();
            
            
            
        }
        
        
    }
    
    
    
    
    
    

     // Commit Record
    /*if(mysql_query($sql_str)){
	   // Do something
        echo "record added";
    }	*/
    
}
?>