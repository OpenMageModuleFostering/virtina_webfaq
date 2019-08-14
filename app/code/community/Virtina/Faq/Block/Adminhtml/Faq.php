<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Block_Adminhtml_Faq extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	
	# Constructor
		
	public function __construct(){
		$this->_controller = 'adminhtml_faq';
		$this->_blockGroup = 'faq';
		$this->_headerText = Mage::helper('faq')->__('Website FAQ Manager');
		$this->_addButtonLabel = Mage::helper('faq')->__('Add Question');
		parent::__construct();
	} 
	
}
