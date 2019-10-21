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

        <!-- Record DELETE Modal -->
        <!-- This is the PEST modal -->
        <div id="commit_record_delete_pest" class="uk-modal">
            <div class="uk-modal-dialog delete_modal">
                <h3>ARE YOU SURE?</h3>
                <p>This action will delete the pest data and <strong>ALL</strong> host data associated with this pest record.</p>
                <div class="uk-modal-footer" style="text-align:right;">
                    <button class="uk-button" onclick="close_delete_modal('pest');">Cancel</button> <button class="uk-button uk-button-primary" onclick="commit_delete('pest');">Delete</button>
                </div>
            </div>
        </div>
        <!-- This is the HOST modal -->
        <div id="commit_record_delete_host" class="uk-modal">
            <div class="uk-modal-dialog delete_modal">
                <h3>ARE YOU SURE?</h3>
                <p>This action will delete ALL data associated with this host record.</p>
                <div class="uk-modal-footer" style="text-align:right;">
                    <button class="uk-button" onclick="close_delete_modal('host');">Cancel</button> <button class="uk-button uk-button-primary" onclick="commit_delete('host');">Delete</button>
                </div>
            </div>
        </div>
              
<div class="pdb_fixedw">

<!-- PDB Master Toolbar -->
    <div class="pdb_activerow">
        <div class="uk-grid">
            <div class="uk-width-7-10">
               <form class="uk-form" id="filterform" name="filterform" onsubmit="apply_filter();return false">
                    <fieldset data-uk-margin>
                        <select name="filter_pests" id="filter_pests" onchange="filter_sub_display(this);">
                            <option selected value="">Look In..</option>
                            <option value="pests">Pests</option>
                            <option value="hosts">Known Hosts</option>
                        </select>
                        
                        <select name="filter_pests_col" id="filter_pests_col" style="display:none;">
                            <option selected value="">Only Look In..</option>
                            <!--<option value="pests">Scientific Name</option>-->
                            <option value="Common-Name">Common Name</option>
                            <option value="Scientific-Name">Scientific Name</option>
                            
                            <option value="Acronym">Acronym</option>
                            <option value="Type">Type</option>
                            <option value="Other-Names">Other Names</option>
                            <option value="Distribution">Distribution</option>
                            <option value="US-Distribution">US Distribution</option>
                            <option value="Countries-Listing-Pest">Countries Listing Pest</option>
                            <option value="Other">Other</option>
                            <option value="Host-Range">Host Range</option>
                        </select>
                        
                        <select name="filter_hosts_col" id="filter_hosts_col" style="display:none;">
                            <option selected value="">Only Look In..</option>
                            <!--<option value="pests">Scientific Name</option>-->
                            <option value="Crop">Crop</option>
                            <option value="Seed-a-Pathway">Seed a Pathway?</option>
                            <option value="References">References</option>
                            <option value="Seed-Information-Comments">Seed Information Comments</option>
                            <option value="Seed-Test">Seed Test</option>
                            <option value="Detection-Type">Detection Type</option>
                            <option value="Test-Reference">Test Reference</option>
                            <option value="Test-Comments">Test Comments</option>
                            <option value="Risk-Type">Risk Type</option>
                            <option value="Risk-References">Risk References</option>
                            <option value="Risk-Comments">Risk Comments</option>
                            <option value="Rec-Health-Test">Rec Health Test</option>
                        </select>
                                 
                        <input type="text" placeholder="Term" id="filter_term">
                        <button class="uk-button"><i class="uk-icon-search"></i> Filter</button>
                        
                        <a href="javascript:;" id="clearfilter" data-uk-tooltip="{delay:800,animation:true}" title="Clear Filter Results" style="display:none;" onclick="clear_filter()"><i class="uk-icon-close uk-icon-small"></i></a>
                    </fieldset>
                </form>
            </div>
            <div class="uk-width-3-10" style="text-align:right;">
                <?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
                <a href="javascript:;" id="toggle_new_pest_form" class="uk-icon-button uk-icon-plus" data-uk-tooltip="{delay:800,animation:true}" title="Add New Pest" onclick="toggle_card_data_new('toggle_new_pest_form','pdb_pest_data_new')"></a>
                &nbsp; | &nbsp; 
                <?php } ?>
                <a href="app/actions/app_export_csv.php" class="uk-icon-button uk-icon-file-text-o" data-uk-tooltip="{delay:800,animation:true}" title="Export Results"></a>
            </div>
        </div>
        <hr>
        <p id="resultsdisplaytext">Showing All Records</p>
        <hr>
    </div>

    
<?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>
<!-- NEW Pest Data Entry -->
<div class="pdb_pest_data_new" id="pdb_pest_data_new" style="display:none;">
    
<form class="uk-form uk-form-stacked" id="pest_card_data_new_form_0" onsubmit="return commit_form_addition('pest_card_data_new_form','pest_card_data_alert','pest_card_data_new_loading','pest_card_data_new_submit','0');">
    
                        
                <div class="uk-grid">
                    <div class="uk-width-1-3">
                            
                        <!-- Hidden Needed -->
                        <input type="hidden" id="form_data_card" name="form_data_card" value="pest_card">
                        <input type="hidden" id="form_data_card_val" name="form_data_card_val" value="0">
                        <input type="hidden" id="form_data_commit" name="form_data_commit" value="a">
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="sci_name">Scientific Name</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="sci_name_div_0" class="card_textarea" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                <input type="hidden" name="sci_name" id="sci_name_0">
                            </div>
                        </div>
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="com_name">Common Name</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="com_name_div_0" class="card_textarea" onpaste="OnPaste_StripFormatting(this, event);"></div>
                                <input type="hidden" name="com_name" id="com_name_0">
                            </div>
                        </div>
                        
                        
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="acrynom">Acronym</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="acrynom_div_0" class="card_textarea"></div>
                                <input type="hidden" name="acrynom" id="acrynom_0">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="type">Type</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="type_div" class="card_textarea"></div>
                                <input type="hidden" name="type" id="type">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="other_names">Other Names</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="other_names_div" class="card_textarea"></div>
                                <input type="hidden" name="other_names" id="other_names">
                                
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="dist">Distribution</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="dist_div" class="card_textarea"></div>
                                <input type="hidden" name="dist" id="dist">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="form-s-t">US Distribution</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="us_dist_div" class="card_textarea"></div>
                                <input type="hidden" name="us_dist" id="us_dist">
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3">
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="countries">Countries Listing Pest</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="countries_div" class="card_textarea"></div>
                                <input type="hidden" name="countries" id="countries">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="other">Other</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="other_div" class="card_textarea"></div>
                                <input type="hidden" name="other" id="other">
                            </div>
                        </div>
                        <div class="uk-form-row">
                            <label class="uk-form-label" for="host_range">Host Range</label>
                            <div class="uk-form-controls">
                                <div contentEditable="true" id="host_range_div" class="card_textarea"></div>
                                <input type="hidden" name="host_range" id="host_range">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <br>
                <div class="uk-form-row" style="text-align:right;">
                    <div class="pest_card_spinner toggle_hidden" id="pest_card_data_new_loading_0">
                        <i class="uk-icon-spinner uk-icon-spin"></i>&nbsp;
                    </div>
                    <button class="uk-button uk-button-primary uk-button-large" id="pest_card_data_new_submit_0">Add Pest</button>
                </div> 
                            
            </form>
    
</div> 
<!-- End NEW Pest Data Entry -->
<?php } ?>
    
<!-- Results LOAD Field -->          
<div class="pdb_results" id="pdb_results"></div>  
<!-- END results load field -->
    
        </div>
        
        
        <footer></footer>

    </body>
</html>