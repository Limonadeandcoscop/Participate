<?php

class Participate_ParticipateController extends Omeka_Controller_AbstractActionController {


    public function init() {
    }


    public function indexAction() {

        $item_id = $this->getParam('item-id');
        if (!$item_id) {
            throw new Exception("Invalid item ID");
        }

        $item = get_record_by_id('Item', $item_id);
        if (!$item) {
            throw new Exception("Invalid item");
        }


        $captchaObj = null;
        if(!current_user()) {
            $captchaObj = $this->_setupCaptcha();
        }

        if ($this->getRequest()->isPost()) {

            if ($captchaObj and !$captchaObj->isValid('foo', $_POST)) {

                $this->_helper->flashMessenger(__('Your CAPTCHA submission was invalid, please try again.'));

            } else {

                if (!($comment = $this->getParam('comment'))) {

                    $this->_helper->flashMessenger(__('The comment is required'), 'error');

                } else {

                    $this->view->comment = $comment;

                    $allowedExtensions  = explode(',', get_option('file_extension_whitelist'));

                    $files = $_FILES['file'];

                    $errors = false;
                    foreach($files as $key => $file) {
                        // Check extension
                        if ($key == 'name') {
                            foreach($file as $f) {
                                if (strlen(trim($f))) {
                                    $extension = pathinfo($f)['extension'];
                                    if (!in_array($extension, $allowedExtensions)) {
                                        $this->_helper->flashMessenger(__("The extension '$extension' is not allowed"), 'error');
                                        $errors = true;
                                    }
                                }
                            }
                        }
                    }

                    if (!$errors) {

                        // Store files on server
                        $links = array();
                        $countfiles = count($_FILES['file']['name']);
                        for ($i=0;$i<$countfiles;$i++) {
                            if (!$_FILES['file']['name'][$i]) continue;
                            $filename = preg_replace("/[^a-z0-9-\.]/", "", strtolower($_FILES['file']['name'][$i]));
                            $filename = ($i+1) .'_'. mktime() .'_'.$filename;
                            $path = PARTICIPATE_UPLOADS_DIR .'/'. $filename;
                            move_uploaded_file($_FILES['file']['tmp_name'][$i], $path);
                            $links[] = absolute_url('plugins/Participate/uploads/' . $filename);
                        }

                        $this->_administratorEmail($item, $comment, $links);
                        $this->_helper->redirector->gotoRoute(array(), 'participate_confirmation');
                    }
                }
            }
        }

        // Render the HTML for the captcha itself.
        // Pass this a blank Zend_View b/c ZF forces it.
        if ($captchaObj) {
            $captcha = $captchaObj->render(new Zend_View);
        } else {
            $captcha = '';
        }

        $this->view->captcha = $captcha;
        $this->view->item = $item;
    }


    public function confirmationAction() {

    }

    protected function _setupCaptcha()
    {
        return Omeka_Captcha::getCaptcha();
    }

    /**
     * Send an email when a user participate
     *
     * @param Item item The related item
     * @param User $comment The comment of the user
     * @param Array $links Links to the files sended by the user
     * @return void
     */
    private function _administratorEmail($item, $comment, $links) {

        $body  = "A user has participate via the site.<br/><br />";
        $body .= "Related item : ".record_url($item, null, true)."<br/><br />";
        $body .= "Comment of the user : \"".$comment."\"<br/>";

        if(count($links)) {
            $body .= "<br />Files sended by the uer :<br />";
            foreach ($links as $link) {
                $body .= $link . "<br />";
            }
        } else {
            $body .= "The user hasn't send files";
        }

        $params['to']           = get_option('administrator_email');
        //$params['recipient']    = $requester->name;
        $params['subject']      = __("A user has participate on openjerusalem.org");
        $params['body']         = $body;
        participate_plugin_send_mail($params);
    }


}

