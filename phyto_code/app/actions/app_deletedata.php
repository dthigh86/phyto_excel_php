<?php
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Delete Data
 
*/

// Config
include '../app_config.php';

// **************************************** //

if (!empty($_POST)) {

    // Is this pest card or host card?
    $cardRecord = $_POST['commitdelete'];
    $deltype = $_POST['type'];                  // *pest / *host
    
    
    // Actions for pest card
    if( $deltype == 'pest'){        
        
        // Add SQL by default
        $sql_str_1 = "Delete from phyto_pest_hosts_crops Where pest_id = ?";
        $stmt = $app_DB->prepare($sql_str_1);
        $stmt->bind_param('i', $cardRecord);
        $stmt->execute();
        
        $sql_str_2 = "Delete from phyto_pest_info Where rid = ?";
        $stmt = $app_DB->prepare($sql_str_2);
        $stmt->bind_param('i', $cardRecord);
        $stmt->execute();

        /* if(mysql_query($sql_str_1)){};
         if(mysql_query($sql_str_2)){};   */   
        
    }
    
    // Actions for host card
    if( $deltype == 'host'){
     
        // Add SQL by default
        $sql_str_1 = "Delete from phyto_pest_hosts_crops Where rid = ?";
        $stmt = $app_DB->prepare($sql_str_1);
        $stmt->bind_param('i', $cardRecord);
        $stmt->execute();
        
        
        //if(mysql_query($sql_str_1)){};    
        
    }
    
}

?>