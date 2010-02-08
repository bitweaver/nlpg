<?php
/*
 * This source code is distributed under the terms as layed out in the
 * GNU General Public License.
 *
 * Purpose: To provide the main entry point in accessing an NLPG repository entry
 *
 * Ported to bitweaver framework by Lester Caine 2006-12-29
 * @version $Id: index.php,v 1.3 2010/02/08 21:27:24 wjames5 Exp $
 */

// Initialization
require_once( '../kernel/setup_inc.php' );

if( !empty( $_REQUEST['usrn'] ) ) {
	header( "location: ".NLPG_PKG_URL."display_street.php?usrn=".( ( int )$_REQUEST['usrn'] ) );
}

if( !empty( $_REQUEST['uprn'] ) ) {
	header( "location: ".NLPG_PKG_URL."display_property.php?uprn=".( ( int )$_REQUEST['uprn'] ) );
}

if( !empty( $_REQUEST['c_id'] ) ) {
	header( "location: ".NLPG_PKG_URL."list_county.php?sort_mode=c_id_asc&list=local&c_id=".$_REQUEST['c_id'] );
}

if( !empty( $_REQUEST['l_id'] ) ) {
	header( "location: ".NLPG_PKG_URL."list_county.php?sort_mode=l_id_asc&list=ward&l_id=".$_REQUEST['l_id'] );
}

$gBitSystem->display( 'bitpackage:nlpg/list_entries.tpl', tra( 'Extract status for: ' ) );
?>