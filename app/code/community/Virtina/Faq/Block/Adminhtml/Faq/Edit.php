<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Block_Adminhtml_Faq_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct(){
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'faq';
        $this->_controller = 'adminhtml_faq';
        $this->_updateButton('save', 'label', Mage::helper('faq')->__('Save Question'));
        $this->_updateButton('delete', 'label', Mage::helper('faq')->__('Delete Question'));
    }
    
    protected function _prepareLayout() {
		parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
	}
	
    public function getHeaderText(){
        if( Mage::registry('faq_data') && Mage::registry('faq_data')->getId() ) {
            return Mage::helper('faq')->__("Edit Question '%s'", $this->htmlEscape(Mage::registry('faq_data')->getName()));
        } else {
            return Mage::helper('faq')->__('Add Question');
        }
    }
}
