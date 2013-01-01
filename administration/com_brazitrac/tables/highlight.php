<?php
/**
 * @version		$Id$
 * @package		brazitrac
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
	var $btracid = null;

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
	 * @param $database JDatabase DBO
	 */
	function __construct(&$database)
	{
		parent::__construct('#__brazitrac_highlight', null, $database);
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
