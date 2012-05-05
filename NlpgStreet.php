<?php
/**
 *----------------------------------------------------------------------
 * nsg street record                                                   
 *----------------------------------------------------------------------
 * Copyright (c) 2007 bitweaver                                        
 *                                                                     
 *                                           |
 *----------------------------------------------------------------------
 * Ported to bitweaver framework by Lester Caine 2006-12-29
 *  $Id$
 */

require_once(NLPG_PKG_PATH.'lib/phpcoord-2.3.php' );

class NlpgStreet extends BitBase {
	var $mUsrn;

	function NlpgStreet( $pUsrn ) {
		parent::__construct();
		if( is_numeric( $pUsrn ) ) {
			$this->mUsrn = $pUsrn;
		}
	}

	function isValid() {
		return( !empty( $this->mUsrn ) && is_numeric( $this->mUsrn ) );
	}

	function load() {
		if( $this->isValid() ) {
			$sql = "SELECT * 
				FROM `".BIT_DB_PREFIX."nlpg_street` s  WHERE `usrn`=?";
			if( $rs = $this->mDb->query( $sql, array( $this->mUsrn ) ) ) {
				if(	$this->mInfo = $rs->fields ) {
					if(	$this->mInfo['swa_org_ref_naming'] == 0 ) {
						global $gBitSystem;
						$gBitSystem->fatalError( tra( 'You do not have permission to access this USRN record' ), 'error.tpl', tra( 'Permission denied.' ) );
					}

					$os1 = new OSRef($this->mInfo['street_start_x'], $this->mInfo['street_start_y']);
					$ll1 = $os1->toLatLng();
					$this->mInfo['street_start_lat'] = $ll1->lat;
					$this->mInfo['street_start_lng'] = $ll1->lng;
					$os1->easting = $this->mInfo['street_end_x'];
					$os1->northing = $this->mInfo['street_end_y'];
					$ll1 = $os1->toLatLng();
					$this->mInfo['street_end_lat'] = $ll1->lat;
					$this->mInfo['street_end_lng'] = $ll1->lng;
					$this->mInfo['display_usrn'] = $this->getUsrnEntryUrl( $this->mInfo['usrn'] );

					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."nlpg_street_xref` x  WHERE `usrn`=?";
					$result = $this->mDb->query( $sql, array( $this->mUsrn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['xref'][] = $res;
					}
					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."nlpg_street_descriptor` s  WHERE `usrn`=?";
					$result = $this->mDb->query( $sql, array( $this->mUsrn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['descriptor'][$res['language']] = $res;
					}
				} else {
					global $gBitSystem;
					$gBitSystem->fatalError( tra( 'USRN does not exist' ), 'error.tpl', tra( 'Not found.' ) );
				}
			}
		}
		return( count( $this->mInfo ) );
	}

	/**
	* Generates the URL to a usrn record reference
	* @param usrn
	* @return the link to display the page.
	*/
	function getUsrnEntryUrl( $usrn = NULL ) {
		$ret = NULL;
		if ( is_numeric( $usrn ) ) {
			$ret = NLPG_PKG_URL."index.php?usrn=".$usrn;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

}
?>
