<?php
//
// +----------------------------------------------------------------------+
// | nlpg blpu property record                                                          |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007 bitcommerce.org                                   |
// |                                                                      |
// | http://www.bitcommerce.org                                           |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license        |
// +----------------------------------------------------------------------+
//  $Id: NlpgProperty.php,v 1.2 2008/11/26 12:03:05 lsces Exp $

require_once(NLPG_PKG_PATH.'lib/phpcoord-2.3.php' );

class NlpgProperty extends BitBase {
	var $mUprn;

	function NlpgProperty( $pUprn ) {
		BitBase::BitBase();
		if( is_numeric( $pUprn ) ) {
			$this->mUprn = $pUprn;
		}
	}

	function isValid() {
		return( !empty( $this->mUprn ) && is_numeric( $this->mUprn ) );
	}

	function load() {
		if( $this->isValid() ) {
			$sql = "SELECT b.*, c.`td` AS class, w.`title` AS ward, p.`title` AS parish 
				FROM `".BIT_DB_PREFIX."nlpg_blpu` b
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_blpu_class` c ON b.`blpu_class` = c.`blpu_id`
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_ons_ward` w ON b.`ward_code` = w.`w_id`
				LEFT JOIN `".BIT_DB_PREFIX."nlpg_ons_parish` p ON b.`parish_code` = p.`p_id`
				WHERE `uprn`=?";
			if( $rs = $this->mDb->query( $sql, array( $this->mUprn ) ) ) {
				if(	$this->mInfo = $rs->fields ) {
					if(	$this->mInfo['local_custodian_code'] == 0 ) {
						global $gBitSystem;
						$gBitSystem->fatalError( tra( 'You do not have permission to access this UPRN record' ), 'error.tpl', tra( 'Permission denied.' ) );
					}

					$os1 = new OSRef($this->mInfo['x_coordinate'], $this->mInfo['y_coordinate']);
					$ll1 = $os1->toLatLng();
					$this->mInfo['prop_lat'] = $ll1->lat;
					$this->mInfo['prop_lng'] = $ll1->lng;
					$this->mInfo['display_uprn'] = $this->getUprnEntryUrl( $this->mInfo['uprn'] );

					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."nlpg_blpu_provenance` p  WHERE p.`uprn`=?";
					$result = $this->mDb->query( $sql, array( $this->mUprn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['provenance'][] = $res;
					}
					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."nlpg_blpu_xref` x  WHERE x.`uprn`=?";
					$result = $this->mDb->query( $sql, array( $this->mUprn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['xref'][] = $res;
					}
					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."nlpg_lpi` lpi  WHERE lpi.`uprn`=?";
					$result = $this->mDb->query( $sql, array( $this->mUprn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['lpi'][$res['language']] = $res;
					}
					$sql = "SELECT * 
						FROM `".BIT_DB_PREFIX."citizen` ci  WHERE ci.`nlpg`=? ORDER BY `surname`, `forename`";
					$result = $this->mDb->query( $sql, array( $this->mUprn ) );
					while( $res = $result->fetchRow() ) {
						$this->mInfo['ci'][] = $res;
					}
					$this->mInfo['display_usrn'] = $this->getUsrnEntryUrl( $this->mInfo['lpi']['ENG']['usrn'] );
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
	function getUprnEntryUrl( $uprn = NULL ) {
		$ret = NULL;
		if ( is_numeric( $uprn ) ) {
			$ret = NLPG_PKG_URL."display_street.php?uprn=".$uprn;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

	/**
	* Generates the URL to a usrn record reference
	* @param usrn
	* @return the link to display the page.
	*/
	function getUsrnEntryUrl( $usrn = NULL ) {
		$ret = NULL;
		if ( is_numeric( $usrn ) ) {
			$ret = NLPG_PKG_URL."index.php?uprn=".$this->mUprn;
		} else {
			$ret = NLPG_PKG_URL."index.php";
		}
		return $ret;
	}

}
?>
