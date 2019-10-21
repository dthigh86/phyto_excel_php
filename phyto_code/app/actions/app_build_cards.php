<?php
session_start();
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Build Pest Cards
 
*/

// Config
require_once '../app_config.php';

// **************************************** //


// For single card load (via filter)
$singleID = trim($_GET['single']);
if( $singleID != '' && is_numeric($singleID) ){
    
   //$build_sql = "Select rid, com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range, orig_dt, review_dt From phyto_pest_info Where rid = ".$singleID; 
    $stmt = $app_DB->prepare('Select rid, com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range, orig_dt, review_dt From phyto_pest_info Where rid = ?');
    $stmt->bind_param('s', $singleID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($rID, $com_name, $sci_name, $acrynom, $type, $other_names, $dist, $us_dist, $countries, $other, $host_range, $orig_dt, $review_dt);
    
    //$result = $stmt->get_result();

} else {
    
    // Pull ALL Pest Cards
    //$build_sql = "Select * From phyto_pest_info Order By sci_name ASC";
    //$result = mysql_query($build_sql);
    
    //$stmt = $app_DB->prepare('Select * From phyto_pest_info Order By sci_name Asc');
    //$stmt->bind_param('s', $singleID);
    //$stmt->execute();
    $stmt = $app_DB->prepare('Select rid, com_name, sci_name, acrynom, type, other_names, dist, us_dist, countries, other, host_range, orig_dt, review_dt From phyto_pest_info Order By sci_name Asc');
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($rID, $com_name, $sci_name, $acrynom, $type, $other_names, $dist, $us_dist, $countries, $other, $host_range, $orig_dt, $review_dt);                         
    //$result = $stmt->get_result();
    
    
}

//$result = mysql_query($build_sql);
//>>>>while ($row = mysql_fetch_array($result)) {
//while ($row = $result->fetch_assoc()) {
while ($stmt->fetch()) {

    /*$rID = $row{'rid'};
    $sci_name = $row{'sci_name'};
    $com_name = $row{'com_name'};
    $acrynom = $row{'acrynom'};
    $type = $row{'type'};
    $other_names = $row{'other_names'};
    $dist = $row{'dist'};
    $us_dist = $row{'us_dist'};
    $countries = $row{'countries'};
    $other = $row{'other'};
    $host_range = $row{'host_range'};
    $orig_dt = $row{'orig_dt'};
    $review_dt = $row{'review_dt'};*/

?>

<!-- Pest CARD -->
    <div class="pdb_pest_card" id="pdb_pest_card_<?php echo $rID ?>">
        
        <div class="uk-grid">
            <div class="uk-width-7-10">
                <h2 id="card_h2_<?php echo $rID ?>"><?php echo $sci_name ?></h2>
                <h3 id="card_h3_<?php echo $rID ?>"><?php echo '('.$com_name.')' ?></h3>
            </div>
            <div class="uk-width-3-10" style="text-align:right;">
                <a href="javascript:;" id="pest_card_data_toggle_<?php echo $rID ?>" class="uk-icon-button uk-icon-chevron-down" onclick="toggle_card_data('pest_card_data_toggle_<?php echo $rID ?>','pest_card_data_<?php echo $rID ?>');" data-uk-tooltip="{delay:800,animation:true}" title="Toggle Data View"></a> 
                <a href="app/actions/app_export_csv.php?sp=<?php echo $rID ?>" class="uk-icon-button uk-icon-file-text-o" data-uk-tooltip="{delay:800,animation:true}" title="Export Pest Data"></a>
                <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
                &nbsp; | &nbsp; <a href="javascript:;" class="uk-icon-button uk-icon-trash pdb_del_btn" data-uk-tooltip="{delay:800,animation:true}" onclick="init_delete_modal(<?php echo $rID ?>,'pest');" title="Delete Pest Data"></a>
                <?php } ?>
            </div>
        </div>      
        
<!-- Form Edit Pest Card -->
        <div class="pest_card_show_hide" id="pest_card_data_<?php echo $rID; ?>">
            <hr>
            
    
            <div class="uk-alert uk-alert-success" id="pest_card_data_alert_<?php echo $rID; ?>" style="display:none;">
                <p><i class="uk-icon-check"></i> Your updates have been saved.</p>
            </div>
 
    
            <form class="uk-form uk-form-stacked" id="pest_card_data_form_<?php echo $rID; ?>" onsubmit="return commit_form_udpate('pest_card_data_form','pest_card_data_alert','pest_card_data_loading','pest_card_data_submit','<?php echo $rID ?>');">
                        
                <div class="uk-grid">
                    <div class="uk-width-1-3">
                            
                        <!-- Hidden Needed -->
                        <input type="hidden" id="form_data_card" name="form_data_card" value="pest_card">
                        <input type="hidden" id="form_data_card_val" name="form_data_card_val" value="<?php echo $rID; ?>">
                        <input type="hidden" id="form_data_commit" name="form_data_commit" value="e">

                         <div class="uk-form-row">
                            <label class="uk-form-label" for="sci_name">Scientific Name</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="sci_name_div_<?php echo $rID ?>" class="card_textarea">
                                <?php echo $sci_name; ?>
                                </div>
                                <input type="hidden" name="sci_name" id="sci_name_<?php echo $rID ?>" value="<?php echo $sci_name; ?>">
                            </div>
                        </div>
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="com_name">Common Name</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="com_name_div_<?php echo $rID ?>" class="card_textarea">
                                <?php echo $com_name; ?>
                                </div>
                                <input type="hidden" name="com_name" id="com_name_<?php echo $rID ?>" value="<?php echo $com_name; ?>">
                            </div>
                        </div>
                        
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="acrynom">Acronym</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="acrynom_div_<?php echo $rID ?>" class="card_textarea">
                                <?php echo $acrynom; ?>
                                </div>
                                <input type="hidden" name="acrynom" id="acrynom_<?php echo $rID ?>" value="<?php echo $acrynom; ?>">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="type">Type</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="type_div" class="card_textarea">
                                <?php echo $type; ?>
                                </div>
                                <input type="hidden" name="type" id="type" value="<?php echo $type; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="other_names">Other Names</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="other_names_div" class="card_textarea">
                                <?php echo $other_names; ?>
                                </div>
                                <input type="hidden" name="other_names" id="other_names" value="<?php echo $other_names; ?>">
                                
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="dist">Distribution</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="dist_div" class="card_textarea">
                                <?php echo $dist; ?>
                                </div>
                                <input type="hidden" name="dist" id="dist" value="<?php echo $dist; ?>">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="form-s-t">US Distribution</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="us_dist_div" class="card_textarea">
                                <?php echo $us_dist; ?>
                                </div>
                                <input type="hidden" name="us_dist" id="us_dist" value="<?php echo $us_dist; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="countries">Countries Listing Pest</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="countries_div" class="card_textarea">
                                <?php echo $countries; ?>
                                </div>
                                <input type="hidden" name="countries" id="countries" value="<?php echo $countries; ?>">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="other">Other</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="other_div" class="card_textarea">
                                <?php echo $other; ?>
                                </div>
                                <input type="hidden" name="other" id="other" value="<?php echo $other; ?>">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="host_range">Host Range</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="host_range_div" class="card_textarea">
                                <?php echo $host_range; ?>
                                </div>
                                <input type="hidden" name="host_range" id="host_range" value="<?php echo $host_range; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="uk-form-row" style="text-align:right;">
                    <div class="pest_card_spinner toggle_hidden" id="pest_card_data_loading_<?php echo $rID ?>">
                        <i class="uk-icon-spinner uk-icon-spin"></i>&nbsp;
                    </div>
                    <em style="color:#e8f5e9;font-size:12px;">Created: <?php echo date( "m/d/Y", strtotime($orig_dt)); ?></em>&nbsp; <?php if(!is_null($review_dt)){ ?><span style="color:#e8f5e9;">|</span> <em style="color:#e8f5e9;font-size:12px;">Reviewed: <?php echo date( "m/d/Y", strtotime($review_dt)); ?></em><?php } ?> 
                    <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
                    &nbsp; <button class="uk-button uk-button-primary uk-button-large" id="pest_card_data_submit_<?php echo $rID ?>">Save<?php if( $_SESSION['SugarAuth'] == 'master' ){ ?> | Review<?php } ?></button> 
                    <?php } ?>
                </div> 
                            
            </form>

<!-- Known Hosts Sub Section Head -->
        <hr>
        <div class="known_hosts_head">
            <div class="uk-grid">
                <div class="uk-width-7-10">
                    <h5>Known Hosts</h5>
                </div>
                <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
                <div class="uk-width-3-10" style="text-align:right;">
                    <a href="javascript:;" id="toggle_new_host_add_<?php echo $rID ?>" class="uk-icon-button uk-icon-plus" data-uk-tooltip="{delay:800,animation:true}" title="Add New Host" onclick="toggle_card_data_new('toggle_new_host_add_<?php echo $rID ?>','host_data_entry_form_<?php echo $rID ?>')"></a>
                </div>
                <?php } ?>
            </div>
        </div>

<?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
<!-- Known Hosts NEW Entry form -->   
<div class="host_data_entry_form" id="host_data_entry_form_<?php echo $rID ?>" style="display:none;">
    
   <form class="uk-form uk-form-stacked" style="margin-bottom:0;" id="pest_host_data_new_form_<?php echo $rID ?>" onsubmit="return commit_form_addition('pest_host_data_new_form','pest_host_data_alert','pest_host_data_loading','pest_host_data_submit','<?php echo $rID ?>');">
                        
            <!-- Hidden Needed -->
            <input type="hidden" id="form_data_card" name="form_data_card" value="host_card">
            <input type="hidden" id="form_data_parent_card_val_<?php echo $rID ?>" name="form_data_parent_card_val" value="<?php echo $rID ?>">
            <input type="hidden" id="form_data_commit" name="form_data_commit" value="a">
                        
            <div class="uk-grid">
                <div class="uk-width-1-4">
                    <h4>Hosts/Crop Infected</h4>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="sci_name">Scientific Name</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_sci_name_div_<?php echo $rID ?>" class="card_textarea"></div>
                                <input type="hidden" name="sci_name" id="host_sci_name_<?php echo $rID ?>" value="">
                            </div>
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="crop">Crop</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_crop_div_<?php echo $rID ?>" class="card_textarea"></div>
                                <input type="hidden" name="host_crop" id="host_crop_<?php echo $rID ?>" value="">
                            </div>
                   
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Seed Information</h4>      
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_pathway">Seed a Pathway?</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_pathway_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_pathway" id="host_seed_pathway" value="">
                            </div>
                    
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_ref">References</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_ref_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_ref" id="host_seed_ref" value="">
                            </div>
                   
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_comments">Comments</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_comments_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_comments" id="host_seed_comments" value="">
                            </div>
                       
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Detection In Seed</h4>       
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_test">Seed Test</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_test_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_detect_test" id="host_seed_detect_test" value="">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_type">Type</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_type_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_detect_type" id="host_seed_detect_type" value="">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="seed_detect_ref">Test Reference</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_ref_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_detect_ref" id="host_seed_detect_ref" value="">
                            </div>
                       
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="see_detect_comments">Test Comments</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_seed_detect_comments_div" class="card_textarea"></div>
                                <input type="hidden" name="host_seed_detect_comments" id="host_seed_detect_comments" value="">
                            </div>
                       
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <h4>Risk Mitigation</h4>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_type">Type</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_risk_mit_type_div" class="card_textarea"></div>
                                <input type="hidden" name="host_risk_mit_type" id="host_risk_mit_type" value="">
                            </div>
                        
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_ref">References</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_risk_mit_ref_div" class="card_textarea"></div>
                                <input type="hidden" name="host_risk_mit_ref" id="host_risk_mit_ref" value="">
                            </div>
                      
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="risk_mit_comments">Comments</label>
                        <div class="uk-form-controls">
                            <!--<textarea name="risk_mit_comments" cols="30" rows="5" placeholder=""></textarea>-->
                            <div contentEditable="true" id="host_risk_mit_comments_div" class="card_textarea"></div>
                                <input type="hidden" name="host_risk_mit_comments" id="host_risk_mit_comments" value="">
                            </div>
                     
                    </div>
                    <div class="uk-form-row">
                        <label class="uk-form-label" for="rec_health_test">Rec Health Test</label>
                        <div class="uk-form-controls">
                            <div contentEditable="true" id="host_rec_health_test_div" class="card_textarea"></div>
                                <input type="hidden" name="host_rec_health_test" id="host_rec_health_test" value="">
                            </div>
                     
                    </div>
                    
                </div>
            </div>
            <br>
            <div class="uk-form-row" style="text-align:right;">
                <div class="host_card_spinner toggle_hidden" id="pest_host_data_loading_<?php echo $rID ?>">
                    <i class="uk-icon-spinner uk-icon-spin"></i>&nbsp;
                </div>
                <button class="uk-button uk-button-primary uk-button-large" id="pest_host_data_submit_<?php echo $rID ?>">Add Host</button>
            </div> 
        </form>
    
    
</div>  <!-- End known hosts new entry form -->
<?php } ?>
            
<div class="pdb_host_results" id="pdb_host_results_<?php echo $rID ?>">
<?php
        
include 'app_build_host_cards.php';
    
?>
</div>
            
        </div></div>
<?php } ?>