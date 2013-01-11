<?php
/**
 * @version $Id: about.html.php 170 2009-09-29 08:49:24Z brazitrac $
 * @copyright Copyright (C) BraziTech
 * @license GNU/GPL
 * @package helpdesk
 */

class HelpdeskHTMLWView extends WView {
	
    /**
	 * Constructor
	 */
	public function __construct() {
        // set the layout
        $this->setLayout('about');

        // let the parent do what it does...
        parent::__construct();
	}

    public function render() {
        // add metadata to the document
        $this->document();

        // continue!
        parent::render();
    }

    private function document() {
        WDocumentHelper::subtitle(JText::_('WHD:ABOUT'));
        WDocumentHelper::addPathwayItem(JText::_('WHD:ABOUT'));
    }
    
}

?>
