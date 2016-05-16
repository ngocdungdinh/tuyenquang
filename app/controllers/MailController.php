<?php

/**
 * BBCMS - A PHP CMS for web newspapers
 *
 * @package  BBCMS
 * @version  1.0
 * @author   BinhBEER <binhbeer@taymay.vn>
 * @link     http://cms.binhbeer.com
 */

class MailController extends BaseController {

	public function getTest()
	{
		$this->data['type'] = 'userfollow';
		$this->data['user'] = Sentry::getUser();
		$this->data['profile'] = User::find(7);
		$this->data['activationUrl'] = 'asdsd';
		$this->data['forgotPasswordUrl'] = 'asdsd';
		$this->data['obj']['title'] = 'userfollow';
		$this->data['obj']['title'] = 'userfollow';

		return View::make('emails.had-answer', $this->data);
	}

	public function processEmailQueue()
	{
    	// get mail queue
    	$mail_queue = EmailQueue::take(5)->get();
    	if($mail_queue->count()) {
    		foreach ($mail_queue as $key => $email) {
				// Send the activation code through email
				$data['body'] = $email->message;
				Mail::send('emails.view', $data, function($m) use ($email)
				{
					$m->to($email->to_email, $email->to_name);
					$m->subject($email->subject);
				});

				$email->delete();
    		}
    	} else {
    		echo 'Not exist queue!';
    	}
	}
}