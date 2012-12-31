<?php
/**
 * @version		$Id$
 * @package		wats
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

// import JTable
jimport('joomla.database.table');

/**
 * Table handler for #__brazitrac_category
 */
class WTableHighlight extends JTable {
	/**
	 * Composite Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $watsid = null;

	/**
	 * Composite Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $ticketid = null;

	/**
	 * Date and time when user last viewed ticket
	 *
	 * @access public
	 * @var string
	 */
	var $datetime = null;

	/**
	 * Constructor
	 *
	 * @access protected
	 * @param $db JDatabase DBO
	 */
	function __construct(&$db)
	{
		parent::__construct('#__brazitrac_highlight', null, $db);
	}

	/**
	 * Determines if buffer is valid.
	 * @todo Add check for datetime
	 */
	function check() {
		if ($ticketid === null) {
			$this->setError("HIGHLIGHT USER MUST EXIST");
			return false;
		}
		
		if ($ticketid === null) {
			$this->setError("HIGHLIGHT TICKET MUST EXIST");
			return false;
		}
		
		return true;
	}
}
?>
