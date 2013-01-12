<?php
/**
 * @package      Joomla.Administrator
 * @subpackage com_brazitrac
 * @copyright  Copyright (C) 2012 Robert Skolnick. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 *BraziTrac brazitrac Controller
 *
 * @package      Joomla.Administrator
 * @subpackage   com_brazitrac
 */
class BraziTracController extends JController
{
   /**
   * @var    string  The default view.
   * @since  2.5
   */
   protected $default_view = 'brazitrac';

   /**
    * Method to display a view.
    *
    * @param   boolean     $cachable   If true, the view output will be cached
    * @param   array       $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
    *
    * @return  JController This object to support chaining.
    */
   public function display($cachable = false, $urlparams = false)
   {
      JLoader::register('BraziTracHelper', JPATH_COMPONENT.'/helpers/brazitrac.php');

      // Load the submenu.
      BraziTracHelper::addSubmenu(JRequest::getCmd('view', 'brazitrac'));

      $view = JRequest::getCmd('view', 'brazitrac');
      $layout = JRequest::getCmd('layout', 'default');
      $id = JRequest::getInt('id');


      parent::display();

      return $this;
   }
}
