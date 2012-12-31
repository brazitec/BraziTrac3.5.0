<?php
/**
 * @version		$Id: dbhelper.php 66 2009-03-31 14:18:46Z brazitrac $
 * @package		brazitrac
 * @package		classes
 * @license		GNU/GPL
 */

/**
 *
 * @static
 */
class WDBHelper {

    /**
	 * Quotes an identifier
	 *
	 * @param $identifier string
	 * @param $database JDatabase
	 */
    function nameQuote($identifier, $database = null) {
	    // prepapre DBO
		if (is_object($database)) {
			$database =& $database;
        } else {
            $database = JFactory::getDBO();
		}
		
		// split the identifier up into names
		$names = explode(".", $identifier);
		
		// build the return value
		foreach($names AS $position => $name) {
		    $names[$position] = $database->nameQuote($name);
		}
		
		return implode(".", $names);
	}

}

?>