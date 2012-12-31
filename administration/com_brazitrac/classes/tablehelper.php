<?php
/**
 * @version		$Id: tablehelper.php 66 2009-03-31 14:18:46Z brazitrac $
 * @package		brazitrac
 * @package		classes
 * @license		GNU/GPL
 */


/**
 *
 * @static
 */
class WTableHelper {

    /**
	 * Gets an instance of a WTable
	 *
	 * @param $type string
	 * @return JTable
	 */
    function getInstance($type) {
	    return JTable::getInstance($type, "WTable", array());
	}

}

?>