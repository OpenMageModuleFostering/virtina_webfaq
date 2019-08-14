<?php
 
 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Block_Adminhtml_Faq_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct(){
		parent::__construct();
		$this->setId('faq_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('faq')->__('FAQ Information'));
	}
	
	protected function _beforeToHtml(){
		$this->addTab('form_section', array(
		  'label'     => Mage::helper('faq')->__('FAQ Information'),
		  'title'     => Mage::helper('faq')->__('FAQ Information'),
		  'content'   => $this->getLayout()->createBlock('faq/adminhtml_faq_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}
