<?php
 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Virtina_Faq_Block_Adminhtml_Faq_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('add_variables' => false, 'add_widgets' => false,'files_browser_window_url'=>$this->getBaseUrl().'admin/cms_wysiwyg_images/index/'));
		$fieldset = $form->addFieldset('faq_form', array('legend'=>Mage::helper('faq')->__('FAQ information')));
		$fieldset->addField('subject', 'editor', array(
		  'name'      => 'subject',
		  'label'     => Mage::helper('faq')->__('subject'),
		  'title'     => Mage::helper('faq')->__('subject'),
		  'style'     => 'width:700px; height:20px;',
		  'wysiwyg'   => false,
		  'required'  => true,
		));
		$fieldset->addField('question', 'editor', array(
		  'name'      => 'question',
		  'label'     => Mage::helper('faq')->__('Question'),
		  'title'     => Mage::helper('faq')->__('Question'),
		  'style'     => 'width:700px; height:100px;',
		  'wysiwyg'   => false,
		  'required'  => true,
		));
		$fieldset->addField('answer', 'editor', array(
		  'name'      => 'answer',
		  'label'     => Mage::helper('faq')->__('Answer'),
		  'title'     => Mage::helper('faq')->__('Answer'),
		  'style'     => 'width:700px; height:200px;',
		  'state'     => 'html',
		  'config'      => $wysiwygConfig,
		  'wysiwyg'   => true,
		  'required'  => true,
		));
		$fieldset->addField('name', 'editor', array(
		  'name'      => 'name',
		  'label'     => Mage::helper('faq')->__('Name'),
		  'title'     => Mage::helper('faq')->__('Name'),
		  'style'     => 'width:700px; height:20px;',
		  'state'     => 'html',
		  'required'  => false,
		));
		$fieldset->addField('email', 'editor', array(
		  'name'      => 'email',
		  'label'     => Mage::helper('faq')->__('Email'),
		  'title'     => Mage::helper('faq')->__('Email'),
		  'style'     => 'width:700px; height:20px;',
		  'wysiwyg'   => false,
		  'required'  => true,
		));		
		$fieldset->addField('status', 'select', array(
		  'label'     => Mage::helper('faq')->__('Status'),
		  'name'      => 'status',
		  'values' => array(				
				'Approved' => 'Approved',
				'Pending'  => 'Pending', ), 
		));		
		$fieldset->addField('checkstatus', 'checkbox', array(
		'label'     => Mage::helper('faq')->__('Do you want to send a notification mail?'),
		'onclick'   => 'this.value = this.checked ? 1 : 2;',
		'name'      => 'checkstatus',
		));    

		if ( Mage::getSingleton('adminhtml/session')->getFaqData() ){
		  $form->setValues(Mage::getSingleton('adminhtml/session')->getFaqData());
		  Mage::getSingleton('adminhtml/session')->setFaqData(null);
		}elseif ( Mage::registry('faq_data') ) {
		  $form->setValues(Mage::registry('faq_data')->getData());
		}
		return parent::_prepareForm();
	}
  
}
