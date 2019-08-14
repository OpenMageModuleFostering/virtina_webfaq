<?php

 /**
 * Virtina
 * @package    Virtina_Faq
 * @copyright  Copyright (c) 2015-2016 Virtina. (http://www.virtina.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class Virtina_Faq_IndexController extends Mage_Core_Controller_Front_Action
{ 
	# saving customer details and question
	
	public function saveAction(){
        if ( $this->getRequest()->getPost() ){
            try {
				$name = $this->getRequest()->getParam('name');
				$subject = $this->getRequest()->getParam('subject');
				$question = $this->getRequest()->getParam('question');
				$email = $this->getRequest()->getParam('email');
				$post_date = date("Y-m-d H:i:s");
                $postData = $this->getRequest()->getPost();                                
                $faqModel = Mage::getModel('faq/faq');
                $faqModel->setId($this->getRequest()->getParam('id'))
					->setSubject($subject)
                    ->setQuestion($question)
                    ->setName($name)
                    ->setStatus('Pending')
                    ->setEmail($email)
                    ->setPostedTime($post_date)
                    ->save();
                Mage::getSingleton('customer/session')->setfaqData(false);
			   
			    $this->_forward('send');                
                return;
            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError($e->getMessage());
                Mage::getSingleton('customer/session')->setfaqData($this->getRequest()->getPost());
                return;
            }
        }
	}

    # sending notification email to Admin
 
	public function sendAction()
	{
		$custom_admin_notify_status=Mage::getStoreConfig('webfaqtab1/general/adminnotification'); 
		 
		$name = $this->getRequest()->getParam('name');
		$email = $this->getRequest()->getParam('email');
		$question = $this->getRequest()->getParam('question');
		$subject = $this->getRequest()->getParam('subject');
		
		$admin_email = Mage::getStoreConfig('trans_email/ident_general/email');		//getting store configured admin email id				   
		$custom_admin_email = Mage::getStoreConfig('webfaqtab1/general/adminmailid');		//getting backend configured custom admin email id
		
		if($custom_admin_email != ''){
			 $admin_email = $custom_admin_email;			
		}

		$emailTemplate = Mage::getModel('core/email_template')->loadDefault('faq_template');		
		$emailTemplateVariables = array();
		$emailTemplateVariables['name'] = $name;
		$emailTemplateVariables['email'] = $email;
		$emailTemplateVariables['question'] = $question;		
		$processedTemplate = $emailTemplate->getProcessedTemplate($emailTemplateVariables);
		$mail = Mage::getModel('core/email')
				 ->setToEmail($admin_email)  
				 ->setBody($processedTemplate)
				 ->setSubject('Website FAQ Details')
				 ->setFromEmail($admin_email)
				 ->setFromName($name)
				 ->setType('html');	
		if($custom_admin_notify_status){
			$mail->send();
		}	
     }
}
