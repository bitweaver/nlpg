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

$nlpg->NlpgExpunge();

$row = 1;
$no11 = 0;
$no12 = 0;
$no15 = 0;
$no21 = 0;
$no22 = 0;
$no23 = 0;
$no24 = 0;
$no25 = 0;
$no26 = 0;
$no27 = 0;
$handle = fopen("data/Full.csv", "r");
while (($data = fgetcsv($handle, 4000, ",")) !== FALSE) {
    $num = count($data);
    $row++;
    if ( $data[0] == 10 ) {
//        vd($data);
    } else if ( $data[0] == 11 ) { $no11++;
    	$nlpg->StreetRecordLoad( $data ); 
    } else if ( $data[0] == 12 ) { $no12++; 
    	$nlpg->StreetRecordXrefLoad( $data ); 
    } else if ( $data[0] == 15 ) { $no15++; 
    	$nlpg->StreetRecordDescriptorLoad( $data ); 
    } else if ( $data[0] == 21 ) { $no21++;
    	$nlpg->BlpuRecordLoad( $data ); 
    } else if ( $data[0] == 22 ) { $no22++; 
    	$nlpg->BlpuProvenanceRecordLoad( $data );
    } else if ( $data[0] == 23 ) { $no23++; 
    	$nlpg->BlpuXrefRecordLoad( $data );
    } else if ( $data[0] == 24 ) { $no24++;
    	$nlpg->LpiRecordLoad( $data ); 
    } else if ( $data[0] == 25 ) { $no25++;
    	//$nlpg->RecordLoad( $data ); 
    } else if ( $data[0] == 26 ) { $no26++;
    	//$nlpg->RecordLoad( $data ); 
    } else if ( $data[0] == 27 ) { $no27++;
    	//$nlpg->RecordLoad( $data ); 
    } else if ( $data[0] == 29 ) {
//        vd($data);
    } else if ( $data[0] == 98 ) {
//        vd($data);
    } else if ( $data[0] == 99 ) {
        //vd($data);
    } else {
		vd($data);
    }
}
fclose($handle);
$gBitSmarty->assign( 'row', $row );
$gBitSmarty->assign( 'no11', $no11 );
$gBitSmarty->assign( 'no12', $no12 );
$gBitSmarty->assign( 'no15', $no15 );
$gBitSmarty->assign( 'no21', $no21 );
$gBitSmarty->assign( 'no22', $no22 );
$gBitSmarty->assign( 'no23', $no23 );
$gBitSmarty->assign( 'no24', $no24 );
$gBitSmarty->assign( 'no25', $no25 );
$gBitSmarty->assign( 'no26', $no26 );
$gBitSmarty->assign( 'no27', $no27 );
$gBitSystem->display( 'bitpackage:nlpg/load.tpl', tra( 'Load results: ' ) );
?>
