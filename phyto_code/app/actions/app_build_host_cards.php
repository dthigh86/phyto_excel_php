<?php    
session_start();
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Build Host Cards
 
*/


// Config
require_once '../app_config.php';


// **************************************** //

//echo $rID;


if(!$rID){
    $rID = trim($_GET["rid"]);
}


//$build_sql_hosts = "Select rid, pest_id, sci_name, crop, seed_pathway, seed_ref, seed_comments, seed_detect_test, seed_detect_type, seed_detect_ref, seed_detect_comments, risk_mit_type, risk_mit_ref, risk_mit_comments, rec_health_test From phyto_pest_hosts_crops Where pest_id = '".$rID."' Order By rid Desc";
//$result_hosts = mysql_query($build_sql_hosts);

    $stmtHosts = $app_DB->prepare('Select rid, pest_id, sci_name, crop, seed_pathway, seed_ref, seed_comments, seed_detect_test, seed_detect_type, seed_detect_ref, seed_detect_comments, risk_mit_type, risk_mit_ref, risk_mit_comments, rec_health_test From phyto_pest_hosts_crops Where pest_id = ? Order By rid Desc');
    $stmtHosts->bind_param('s', $rID);

    $stmtHosts->execute();
$stmtHosts->store_result();
    
$stmtHosts->bind_result($rID_Host, $pest_id, $sci_name_host, $crop, $seed_pathway, $seed_ref, $seed_comments, $seed_detect_test, $seed_detect_type, $seed_detect_ref, $seed_detect_comments, $risk_mit_type, $risk_mit_ref, $risk_mit_comments, $rec_health_test); 
    



//$resultHosts = $stmtHosts->get_result();


//while ($rowHosts = mysql_fetch_array($result_hosts)) {
/////while ($rowHosts = $resultHosts->fetch_assoc()) {
while ($stmtHosts->fetch()) {
	  
   /* $rID_Host = $rowHosts{'rid'};
    $pest_id = $rowHosts{'pest_id'};
    $sci_name_host = $rowHosts{'sci_name'};
    $crop = $rowHosts{'crop'};
    $seed_pathway = $rowHosts{'seed_pathway'};
    $seed_ref = $rowHosts{'seed_ref'};
    $seed_comments = $rowHosts{'seed_comments'};
    $seed_detect_test = $rowHosts{'seed_detect_test'};
    $seed_detect_type = $rowHosts{'seed_detect_type'};
    $seed_detect_ref = $rowHosts{'seed_detect_ref'};
    $seed_detect_comments = $rowHosts{'seed_detect_comments'};
    $risk_mit_type = $rowHosts{'risk_mit_type'};
    $risk_mit_ref = $rowHosts{'risk_mit_ref'};
    $risk_mit_comments = $rowHosts{'risk_mit_comments'};
    $rec_health_test = $rowHosts{'rec_health_test'};*/
     
    
?>
<!-- Start Pest Known Hosts Cards -->
<div class="pest_host_card" id="pdb_host_card_<?php echo $rID_Host ?>">
    
    <div class="uk-grid">
        <div class="uk-width-7-10">
            <h2 id="host_h2_<?php echo $rID_Host ?>"><?php echo $sci_name_host ?></h2>
        </div>
        <div class="uk-width-3-10" style="text-align: right;">
            <a href="javascript:;" onclick="toggle_card_data('pest_host_data_toggle_<?php echo $rID ?>_<?php echo $rID_Host ?>','pest_host_data_<?php echo $rID ?>_<?php echo $rID_Host ?>');" id="pest_host_data_toggle_<?php echo $rID ?>_<?php echo $rID_Host ?>" class="uk-icon-button uk-icon-chevron-down" data-uk-tooltip="{delay:800,animation:true}" title="Toggle Data View"></a>
                            <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
            &nbsp; | &nbsp; <a href="javascript:;" class="uk-icon-button uk-icon-trash pdb_del_btn" data-uk-tooltip="{delay:800,animation:true}" onclick="init_delete_modal(<?php echo $rID_Host ?>,'host');" title="Delete Host Data"></a>
            <?php } ?>
            
        </div>
    </div>
                    
    <!-- Start Pest Known Card Toggle -->
    <div id="pest_host_data_<?php echo $rID ?>_<?php echo $rID_Host ?>" class="pest_card_show_hide">
        <hr>
    
        <div class="uk-alert uk-alert-success" id="pest_host_data_alert_<?php echo $rID_Host ?>" style="display:none;">
            <p><i class="uk-icon-check"></i> Your updates have been saved.</p>
        </div>
    
        <!-- Known Host Edit -->
        <form class="uk-form uk-form-stacked host_data_edit_form" style="margin-bottom:0;" id="pest_host_data_form_<?php echo $rID_Host ?>" onsubmit="return commit_form_udpate('pest_host_data_form','pest_host_data_alert','pest_host_data_loading','pest_host_data_submit','<?php echo $rID_Host; ?>','<?php echo $rID; ?>');">
                        
            <!-- Hidden Needed -->
            <input type="hidden" id="form_data_card" name="form_data_card" value="host_card">
            <input type="hidden" id="form_data_card_val" name="form_data_card_val" value="<?php echo $rID_Host ?>">
            <input type="hidden" id="form_data_commit" name="form_data_commit" value="e">
                        
             <div class="uk-grid">
                <div class="uk-width-1-4">
                    <h4>Hosts/Crop Infected</h4>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="sci_name">Scientific Name</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_sci_name_div_<?php echo $rID_Host ?>" class="card_textarea"><?php echo $sci_name_host; ?></div>
                                <input type="hidden" name="sci_name" id="host_sci_name_<?php echo $rID_Host ?>" value="<?php echo $sci_name_host; ?>">
                            </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="crop">Crop</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_crop_div_<?php echo $rID_Host ?>" class="card_textarea"><?php echo $crop ?></div>
                                <input type="hidden" name="host_crop" id="host_crop_<?php echo $rID_Host ?>" value="<?php echo $crop ?>">
                            </div>
                   
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Seed Information</h4>      
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_pathway">Seed a Pathway?</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_pathway_div" class="card_textarea"><?php echo $seed_pathway ?></div>
                                <input type="hidden" name="host_seed_pathway" id="host_seed_pathway" value="<?php echo $seed_pathway ?>">
                            </div>
                    
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_ref">References</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_ref_div" class="card_textarea"><?php echo $seed_ref ?></div>
                                <input type="hidden" name="host_seed_ref" id="host_seed_ref" value="<?php echo $seed_ref ?>">
                            </div>
                   
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_comments">Comments</label>
                        <div class="uk-form-controls">
                             <div contentEditable="true" id="host_seed_comments_div" class="card_textarea"><?php echo $seed_comments ?></div>
                                <input type="hidden" name="host_seed_comments" id="host_seed_comments" value="<?php echo $seed_comments ?>">
                            </div>
                       
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Detection In Seed</h4>       
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_test">Seed Test</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_test_div" class="card_textarea"><?php echo $seed_detect_test ?></div>
                                <input type="hidden" name="host_seed_detect_test" id="host_seed_detect_test" value="<?php echo $seed_detect_test ?>">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_type">Type</label>
                        <div class="uk-form-controls">
                             <div contentEditable="true" id="host_seed_detect_type_div" class="card_textarea"><?php echo $seed_detect_type ?></div>
                                <input type="hidden" name="host_seed_detect_type" id="host_seed_detect_type" value="<?php echo $seed_detect_type ?>">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_ref">Test Reference</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_ref_div" class="card_textarea"><?php echo $seed_detect_ref ?></div>
                                <input type="hidden" name="host_seed_detect_ref" id="host_seed_detect_ref" value="<?php echo $seed_detect_ref ?>">
                            </div>
                       
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="see_detect_comments">Test Comments</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_comments_div" class="card_textarea"><?php echo $seed_detect_comments ?></div>
                                <input type="hidden" name="host_seed_detect_comments" id="host_seed_detect_comments" value="<?php echo $seed_detect_comments ?>">
                            </div>
                       
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Risk Mitigation</h4>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_type">Type</label>
                        <div class="uk-form-controls">
                           <div contentEditable="true" id="host_risk_mit_type_div" class="card_textarea"><?php echo $risk_mit_type ?></div>
                                <input type="hidden" name="host_risk_mit_type" id="host_risk_mit_type" value="<?php echo $risk_mit_type ?>">
                            </div>
                        
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_ref">References</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_risk_mit_ref_div" class="card_textarea"><?php echo $risk_mit_ref ?></div>
                                <input type="hidden" name="host_risk_mit_ref" id="host_risk_mit_ref" value="<?php echo $risk_mit_ref ?>">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_comments">Comments</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_risk_mit_comments_div" class="card_textarea"><?php echo $risk_mit_comments ?></div>
                                <input type="hidden" name="host_risk_mit_comments" id="host_risk_mit_comments" value="<?php echo $risk_mit_comments ?>">
                            </div>
                     
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="rec_health_test">Rec Health Test</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_rec_health_test_div" class="card_textarea"><?php echo $rec_health_test ?></div>
                                <input type="hidden" name="host_rec_health_test" id="host_rec_health_test" value="<?php echo $rec_health_test ?>">
                            </div>
                     
                    </div>
                </div>
            </div>
            
            <br>
            <div class="uk-form-row" style="text-align:right;">
                <div class="host_card_spinner toggle_hidden" id="pest_host_data_loading_<?php echo $rID_Host ?>">
                    <i class="uk-icon-spinner uk-icon-spin"></i>&nbsp;
                </div>
                <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
                <button class="uk-button uk-button-primary uk-button-large" id="pest_host_data_submit_<?php echo $rID_Host ?>">Save Updates</button>
                <?php } ?>
            </div> 
        </form>
        
    </div>  <!-- End host data toggle -->
</div>      <!-- End Known Pest Card -->
                    
<?php } ?>    