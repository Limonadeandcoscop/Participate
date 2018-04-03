<?php

/**
 * Send the subscription link
 *
 * If $params['to'] isn't specify, send the email to current user
 *
 * @param Array $params An array of params
 * @param Boolean $debug Whether of not dispays debug info and send the mail
 * @return void
 */
function newsletter_send_mail($params, $debug = false) {

	$user		= current_user();
	$subject	= $params['subject'];
	$body 		= $params['body'];
	$from 		= isset($params['from']) ? $params['from'] : get_option('administrator_email');
	$sender		= isset($params['sender']) ? $params['sender'] : get_option('site_title');
	$to 		= isset($params['to']) ? $params['to'] : $user->email;
	$recipient	= isset($params['recipient']) ? $params['recipient'] : $user->name;

	if ($debug) {
		echo "<b>A : </b>".$recipient." &lt;" . $to . "&gt;<br />";
		echo "<b>De : </b>".$sender." &lt;" . $from . "&gt;<br />";
		echo "<b>Message : </b>" . $body . "<br />";
	}

	$mail = new Zend_Mail('UTF-8');
    $mail->setBodyHtml($body);
    $mail->setFrom($from, $sender);
    $mail->addTo($to, $recipient);
    $mail->setSubject($subject);
    $mail->addHeader('X-Mailer', 'PHP/' . phpversion());
    if (!$debug) {
	    try {
	        $mail->send();
	    } catch (Exception $e) {
	        _log($e);
	    }
	}
}
