<?php
global $gBitSystem, $gBitUser;
$registerHash = array(
	'package_name' => 'nlpg',
	'package_path' => dirname( __FILE__ ).'/',
	'homeable' => TRUE,
);
$gBitSystem->registerPackage( $registerHash );


if( $gBitSystem->isPackageActive( 'nlpg' ) &&  $gBitUser->hasPermission( 'p_nlpg_view' )) {
	$menuHash = array(
		'package_name'  => NLPG_PKG_NAME,
		'index_url'     => NLPG_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:nlpg/menu_nlpg.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
	$gLibertySystem->registerService( 'nlpg', NLPG_PKG_NAME, array(
		'content_list_sql_function' => 'nlpg_content_list_sql',
		)
	);

}
?>
