<?php
/*
 * Created on 5 Jan 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

// Initialization
require_once( '../kernel/setup_inc.php' );
require_once(NLPG_PKG_PATH.'BitNlpg.php' );

// Is package installed and enabled
$gBitSystem->verifyPackage('nlpg' );

// Now check permissions to access this page
$gBitSystem->verifyPermission('p_nlpg_admin' );

$nlpg = new BitNlpg();
//$listnlpg = $nlpg->getList( $_REQUEST );
set_time_limit(0);

$nlpg->UKPCExpunge();

$row = 1;
$handle = fopen("data/FullUKPostcode.csv", "r");
while (($data = fgetcsv($handle, 4000, ",")) !== FALSE) {
	$num = count($data);
	$row++;
	$nlpg->UKPCRecordLoad( $data ); 
}
fclose($handle);
$gBitSmarty->assign( 'row', $row );
$gBitSystem->display( 'bitpackage:nlpg/load_ukpc.tpl', tra( 'Load results: ' ) );
?>
