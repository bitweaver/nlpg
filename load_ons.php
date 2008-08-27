<?php
/*
 * Created on 5 Jan 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

// Initialization
require_once( '../bit_setup_inc.php' );
require_once(NLPG_PKG_PATH.'BitNlpg.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('nlpg' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_admin' );

$nlpg = new BitNlpg();
//$listnlpg = $nlpg->getList( $_REQUEST );

$nlpg->OnsExpunge();

$row = 0;
$handle = fopen("data/Local_Authorities.csv", "r");
if ( $handle == FALSE) {
	$row = -999;
} else {
	while (($data = fgetcsv($handle, 400, ",")) !== FALSE) {
    	$row++;
    	$nlpg->OnsLARecordLoad( $data );
	}
	fclose($handle);
}
$gBitSmarty->assign( 'local', $row );

$row = 0;
$handle = fopen("data/Ward.csv", "r");
if ( $handle == FALSE) {
	$row = -999;
} else {
	while (($data = fgetcsv($handle, 4000, ",")) !== FALSE) {
    	$row++;
		$nlpg->OnsWardRecordLoad( $data );
	} 
	fclose($handle);
}
$gBitSmarty->assign( 'ward', $row );

$row = 0;
$handle = fopen("data/Parish.csv", "r");
if ( $handle == FALSE) {
	$row = -999;
} else {
	while (($data = fgetcsv($handle, 4000, ",")) !== FALSE) {
    	$row++;
	   	$nlpg->OnsParishRecordLoad( $data ); 
	}
	fclose($handle);
}
$gBitSmarty->assign( 'parish', $row );

$nlpg->OnsRecordsFix();

$gBitSystem->display( 'bitpackage:nlpg/load_ons.tpl', tra( 'Load results: ' ) );
?>
