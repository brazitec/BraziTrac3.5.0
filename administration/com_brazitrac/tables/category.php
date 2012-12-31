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
 * Table handler for #__wats_category
 */
class WTableCategory extends JTable {
	/**
	 * Primary Key
	 *
	 * @access	public
	 * @var		int
	 */
	var $catid = null;

	/**
	 * Category name
	 *
	 * @access	public
	 * @var		string
	 */
	var $name = null;
	
	/**
	 * Description name
	 *
	 * @access	public
	 * @var		string
	 */
	var $description = null;

	/**
	 * Category image
	 *
	 * @access	public
	 * @var		string
	 */
	var $image = null;

	/**
	 * Constructor
	 *
	 * @access	protected
	 * @param $db JDatabase DBO
	 */
	function __construct(&$db)
	{
		parent::__construct('#__wats_category', 'catid', $db);
	}

	/**
	 * Determines if buffer is valid.
	 */
	function check() {
		if (strlen($this->name) > 0) {
			$this->setError("CATEGORY NAME MUST EXIST");
			return false;
		}
		return true;
	}
}
?>
