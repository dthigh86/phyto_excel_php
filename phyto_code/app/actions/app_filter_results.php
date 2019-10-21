<?php
session_start();
/**
 * Phyto DB
 * 2015 Creative Freedom
 
 * - Filter Results
 
*/

// Config
require_once '../app_config.php';

// **************************************** //

$searchterm = trim($_GET['sfor']);
$searchon = trim($_GET['son']);
$restrictto = trim($_GET['resto']);

$dbtable = "phyto_pest_info";
if( $searchon == 'hosts' ){
    $dbtable = "phyto_pest_hosts_crops";
}

$restrictcol = "sci_name";
if( $restrictto != '' ){
    
    // cross ref select (no column names in page code foo..
    if( $searchon == 'pests' ){
        if( $restrictto == 'Common-Name' ){ $restrictcol = 'com_name'; }
        if( $restrictto == 'Scientific-name' ){ $restrictcol = 'sci_name'; }
        
        if( $restrictto == 'Acronym' ){ $restrictcol = 'acrynom'; }
        if( $restrictto == 'Type' ){ $restrictcol = 'type'; }
        if( $restrictto == 'Other-Names' ){ $restrictcol = 'other_names'; }
        if( $restrictto == 'Distribution' ){ $restrictcol = 'dist'; }
        if( $restrictto == 'US-Distribution' ){ $restrictcol = 'us_dist'; }
        if( $restrictto == 'Countries-Listing-Pest' ){ $restrictcol = 'countries'; }
        if( $restrictto == 'Other' ){ $restrictcol = 'other'; }
        if( $restrictto == 'Host-Range' ){ $restrictcol = 'host_range'; }     
    } else {
        
        if( $restrictto == 'Crop' ){ $restrictcol = 'crop'; }
        if( $restrictto == 'Seed-a-Pathway' ){ $restrictcol = 'seed_pathway'; }
        if( $restrictto == 'References' ){ $restrictcol = 'seed_ref'; }
        if( $restrictto == 'Seed-Information-Comments' ){ $restrictcol = 'seed_comments'; }
        if( $restrictto == 'Seed-Test' ){ $restrictcol = 'seed_detect_test'; }
        if( $restrictto == 'Detection-Type' ){ $restrictcol = 'seed_detect_type'; }
        if( $restrictto == 'Test-Reference' ){ $restrictcol = 'seed_detect_ref'; }
        if( $restrictto == 'Test-Comments' ){ $restrictcol = 'seed_detect_comments'; }
        if( $restrictto == 'Risk-Type' ){ $restrictcol = 'risk_mit_type'; }
        if( $restrictto == 'Risk-References' ){ $restrictcol = 'risk_mit_ref'; }
        if( $restrictto == 'Risk-Comments' ){ $restrictcol = 'risk_mit_comments'; }
        if( $restrictto == 'Rec-Health-Test' ){ $restrictcol = 'rec_health_test'; }
    }

}

// Build our SQL

if( $searchon == 'pests' ){
    
    $build_sql = "Select rid, sci_name, ".$restrictcol." From phyto_pest_info Where ".$restrictcol." like ? Order By rid Desc";
    
    $likevar = "%".$searchterm."%";
    $stmt = $app_DB->prepare($build_sql);
    $stmt->bind_param('s', $likevar);
    $stmt->execute();
    //$stmt->store_result();
    $stmt->bind_result($rid, $sci_name, $result); 
    //$stmt->close();
    
} else {
    
    $build_sql = "Select pest_id, sci_name, ".$restrictcol." From phyto_pest_hosts_crops Where ".$restrictcol." like ? Order By rid Desc";
    
    $likevar = "%".$searchterm."%";
    $stmt = $app_DB->prepare($build_sql);
    $stmt->bind_param('s', $likevar);
    $stmt->execute();
   // $stmt->store_result();
    $stmt->bind_result($pestid, $sci_name, $result);  
    //$stmt->close();
    
}


//$result = mysql_query($build_sql);
//>>>>while ($row = mysql_fetch_array($result)) {
//while ($row = $result->fetch_assoc()) {
//while ($stmt->fetch()) {
 
    
/*echo $searchon."<br>";
echo $dbtable."<br>";
echo $restrictto."<br>";
echo $build_sql; */

//$result = mysql_query($build_sql);
//while ($row = mysql_fetch_array($result)) {
while ($stmt->fetch()) {

?>
  
<?php if( $dbtable == "phyto_pest_info" ){ ?>  

<div class="filterresult">
    
    <?php // Pest Results ?>
    <h4><?php echo highlight($sci_name, $searchterm) ?></h4>
    <?php if( $restrictto != "sci_name" ){ ?>
    <p>
        <strong><?php echo $restrictto; ?></strong><br>
        <?php echo highlight($result, $searchterm) ?>
    </p>
    <?php } ?>
    <a href="javascript:;" onclick="loadcard(<?php echo $rid ?>);"><i class="uk-icon-edit "></i> View<?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>/Edit<?php } ?> This Card</a>

    </div>
    <hr>

<?php } else { ?>

    <?php // Host Results ?>
    <h4><?php echo highlight($sci_name, $searchterm) ?></h4>
    <?php if( $restrictto != "sci_name" ){ ?>
    <p>
        <strong><?php echo $restrictto; ?></strong><br>
        <?php echo highlight($result, $searchterm) ?>
    </p>
    <?php } ?>
    <!--<p style="color:#ccc;">Child of Pest: <?php //echo disp_pest_sciname($pestid); ?></p>-->
    <a href="javascript:;" onclick="loadcard(<?php echo $pestid ?>);"><i class="uk-icon-edit "></i> View<?php if( $_SESSION['SugarAuth'] !== 'readonly' ){ ?>/Edit<?php } ?> Parent Pest Card</a>

    </div>
    <hr>
    
<?php } ?>  


<!-- Pest CARD -->
<?php } ?>

<?php

function highlight($text, $words) {
    preg_match_all('~\w+~', $words, $m);
    if(!$m)
        return $text;
    $re = '~\\b(' . implode('|', $m[0]) . ')\\b~i';
    return preg_replace($re, '<span class="filterfound">$0</span>', $text);
}

function disp_pest_sciname($pestID){
    
    //$build_sql = "Select sci_name From phyto_pest_info Where rid = ".$pestID;
    //$result = mysql_query($build_sql);
    //$row = mysql_fetch_array($result);
    //return $row{'sci_name'};
    //echo $pestID;
      
    global $app_DB;
    //$thisParentIs = "Unknown";

    $queryStr = 'Select sci_name From phyto_pest_info Where rid = '.$pestID;
    $query=$app_DB->query($queryStr);
    $first_fetch=$query->fetch_array(MYSQLI_ASSOC);
    echo $first_fetch['sci_name'];
    
    return $thisParentIs;

}

?>