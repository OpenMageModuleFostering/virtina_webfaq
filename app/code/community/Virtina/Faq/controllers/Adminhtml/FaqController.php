<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_Adminhtml_FaqController extends Mage_Adminhtml_Controller_action
{
    protected function _initAction(){
        $this->loadLayout()
            ->_setActiveMenu('faq/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Website FAQ Manager'), Mage::helper('adminhtml')->__('Website FAQ Manager'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->renderLayout();
    }

    public function editAction(){
        $faqId     = $this->getRequest()->getParam('id');
        $faqModel  = Mage::getModel('faq/faq')->load($faqId);

        if ($faqModel->getId() || $faqId == 0) {

            Mage::register('faq_data', $faqModel);

            $this->loadLayout();
            $this->_setActiveMenu('faq/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Website FAQ Manager'), Mage::helper('adminhtml')->__('Website FAQ Manager'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('faq/adminhtml_faq_edit'))
                 ->_addLeft($this->getLayout()->createBlock('faq/adminhtml_faq_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('faq')->__('FAQ does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
    public function newAction(){
        $this->_forward('edit');
    }
   
    public function saveAction(){
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $faqModel = Mage::getModel('faq/faq');               
                $admin_email = Mage::getStoreConfig('trans_email/ident_general/email'); 
				$emailid = $postData['email'];
				$send_mail_status=$postData['checkstatus'];
				$post_date = date("Y-m-d H:i:s");
							
				$faqModel->setId($this->getRequest()->getParam('id'))
					->setName($postData['name'])
					->setEmail($emailid)
					->setSubject($postData['subject'])
					->setQuestion($postData['question'])
					->setAnswer($postData['answer'])
					->setPostedTime($post_date)
					->setStatus($postData['status'])
					->setCheckstatus($postData['checkstatus'])
					->save();
			
                $parameters =array('emailid'=>$emailid,'send_mail_status'=>$send_mail_status);
                   
				$this->_forward('send',NULL,NULL,$parameters);
											
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('FAQ is successfully saved'));
                Mage::getSingleton('adminhtml/session')->setfaqData(false);
                               
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setfaqData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction(){
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $faqModel = Mage::getModel('faq/faq');               
                $faqModel->setId($this->getRequest()->getParam('id'))
						 ->delete();                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('FAQ is successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    # sending notification email to customer

    public function sendAction() {
		$emailid = $this->getRequest()->getParam('emailid');
		$send_mail_status = $this->getRequest()->getParam('send_mail_status');
		$cms_page_name = Mage::getStoreConfig('webfaqtab1/general/dropdown'); 

		$admin_email = Mage::getStoreConfig('trans_email/ident_general/email');						   
		$custom_admin_email = Mage::getStoreConfig('webfaqtab1/general/adminmailid');
		
		if($custom_admin_email != ''){
			 $admin_email = $custom_admin_email;			
		}		
		  				
		if($send_mail_status == 1){			
			$url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).$cms_page_name;
			$emailTemplate = Mage::getModel('core/email_template')->loadDefault('faq_customer_template');		
			$emailTemplateVariables = array();
			$emailTemplateVariables['url'] = $url;
			$emailTemplateVariables['email'] = $emailid;		
			$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
			$mail = Mage::getModel('core/email')
					 ->setToEmail($emailid)
					 ->setBody($processedTemplate)
					 ->setSubject('Website FAQ Reply')
					 ->setFromEmail($admin_email)
					 ->setFromName($name)
					 ->setType('html');	
			try {
				$mail->send();
			} catch(Exception $error) {
				Mage::getSingleton('core/session')->addError($error->getMessage());
				return false;
			}					
		} else {
			return;
		}
	}
	
	# Permission Allowed
	
	protected function _isAllowed(){
		return true;
	}	
	
	# Mass delete faq details
	
	public function massDeleteAction()
	{
		$faqIds = $this->getRequest()->getParam('faq_id');
		if(!is_array($faqIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('faq')->__('Please select item(es).'));
		} else {
		try {
			$faqModel = Mage::getModel('faq/faq');
			foreach ($faqIds as $faqId) {
				$faqModel->load($faqId)->delete();
			}
			Mage::getSingleton('adminhtml/session')->addSuccess(
			Mage::helper('faq')->__('Total of %d record(s) were deleted.', count($faqIds)
			));
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		}		 
		$this->_redirect('*/*/index');
	}
}
