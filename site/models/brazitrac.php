<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * BRAZITRAC Model
 */
class BraziTracModelBraziTrac extends JModelItem
{
        /**
         * @var string msg
         */
        protected $msg;
 
        /**
         * Get the message
         * @return string The message to be displayed to the user
         */
        public function getMsg() 
        {
                if (!isset($this->msg)) 
                {
                        $id = JRequest::getInt('id');
                        switch ($id) 
                        {
                        case 2:
                                $this->msg = 'Good bye BraziTrac User!';
                        break;
                        default:
                        case 1:
                                $this->msg = 'Hello BraziTrac User!';
                        break;
                        }
                }
                return $this->msg;
        }
}