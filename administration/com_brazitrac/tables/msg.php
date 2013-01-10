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
class WTableMsg extends JTable {
	/**
	 * Primary Key
	 *
	 * @access public
	 * @var int
	 */
	var $msgid = null;
	
	/**
	 * Ticket the message belongs to
	 *
	 * @access public
	 * @var int
	 */
	var $ticketid = null;
	
	/**
	 * Message owner
	 *
	 * @access public
	 * @var int
	 */
	var $btracid = null;

	/**
	 * Message content
	 *
	 * @access public
	 * @var string
	 */
	var $msg = null;

	/**
	 * Message submission date and time
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
		parent::__construct('#__brazitrac_msg', 'msgid', $database);
	}

	/**
	 * Determines if buffer is valid.
	 *
	 * @todo Add check for date and time
	 */
	function check() {
		if ($this->ticketid === null) {
			$this->setError("MESSAGE TICKET MUST EXIST");
			return false;
		}
		
		if ($this->btracid === null) {
			$this->setError("MESSAGE USER MUST EXIST");
			return false;
		}
		
		if ($this->message === null) {
			$this->setError("MESSAGE CONTENT MUST EXIST");
			return false;
		}
		
		return true;
	}
}
?>
