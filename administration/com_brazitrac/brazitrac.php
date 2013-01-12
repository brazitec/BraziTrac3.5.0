<?php
/**
 * @package    Joomla.Site
 * @subpackage com_brazitrac
 * @copyright  Copyright (C) 2012 Robert Skolnick. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_brazitrac')) {
       return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependencies
jimport('joomla.application.component.controller');

$controller = JController::getInstance('BraziTrac');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();