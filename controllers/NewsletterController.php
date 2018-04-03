<?php

class Newsletter_NewsletterController extends Omeka_Controller_AbstractActionController {

    
    public function init() {
    }

   
    public function indexAction() {

        if ($this->getRequest()->isPost()) {

            $email = $this->getParam('email');

            if (!strlen(trim($email))) {
                $this->_helper->flashMessenger(__('Email address is required'), 'error');
            } elseif (!Zend_Validate::is($email, 'EmailAddress')) {
                $this->_helper->flashMessenger(__('Invalid email address'), 'error');
            } elseif (Newsletter::emailExists($email)) {
                $this->_helper->flashMessenger(__('Email address already in database'), 'error');                
            } else {
                $newsletter = new Newsletter;
                $key = bin2hex(openssl_random_pseudo_bytes(30));
                $newsletter->email  = $email;
                $newsletter->key    = $key;
                $newsletter->status = 'waiting';
                $newsletter->save();

                $this->_newsletterEmail($newsletter->id, $email, $key);
                $this->_helper->redirector->gotoRoute(array(), 'newsletter_confirmation');
            }
        }
    }


    public function confirmationAction() {}


    public function okAction() {}


    public function validationAction() {

        $this->_helper->viewRenderer->setNoRender();

        $id  = $this->getParam('id');
        $key = $this->getParam('key');

        $user = get_record_by_id('Newsletter', $id);

        if ($user) {
            if ($user->key == $key) {

                // Update status
                $user->status = 'ok';
                $user->save();
                $this->_helper->redirector->gotoRoute(array(), 'newsletter_ok');
            }
        }
        throw new Exception("Invalid parameter", 1);
    } 


    /**
     * Send an email when a user request a subscrbtion
     */
    private function _newsletterEmail($id, $email, $key) {

        $link = absolute_url('newsletter/validation/id/'.$id.'/key/'.$key);
        $body  = "Please confirm your subscribtion to Open Jerusalem newsletter by clicking on <a href='".$link."'>the link</a> below :<br/><br />";
        $body .= $link."<br/><br />";

        $params['to']      = $email;
        $params['from']    = get_option('administrator_email');
        $params['subject'] = __("OpenJerusalem newsletter subscription");
        $params['body']    = $body;
        newsletter_send_mail($params);
    }


}

