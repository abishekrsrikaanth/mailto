<?php namespace Abishekrsrikaanth\Mailto\Providers\PostMark;

use Illuminate\Support\Facades\Config;
use Guzzle\Service\Client;

class PostMark
{
	private $_api_url = "https://api.postmarkapp.com/";
	private $_api_send_url = "email";
	private $_api_batch_url = "email/batch";
	private $_send_object = array();
	private $_credentials = array();

	/**
	 * Constructor initializes the API Key
	 *
	 * @param array $credentials
	 *
	 * @throws \Exception
	 */
	public function __construct($credentials = array())
	{
		if (count($credentials) > 0) {
			$api_key             = $credentials['apikey'];
			$this->__credentials = $api_key;
		} else {
			$api_key = Config::get("mailto::providers.postmark.apikey");
			if (empty($api_key))
				throw new \Exception('The Post Credentials is missing');
			else
				$this->_credentials = $api_key;
		}
	}

	/**
	 * Creates a new Instance of PostMarkMessage Class
	 *
	 * @return PostMarkMessage
	 */
	public function getMessageInstance()
	{
		return new PostMarkMessage();
	}

	/**
	 * Send a new transactional message through PostmarkApp
	 *
	 * @param PostMarkMessage $postMarkMessage
	 *
	 * @return string
	 */
	public function send(PostMarkMessage $postMarkMessage)
	{
		$this->_send_object = $this->getMailObject($postMarkMessage);

		return $this->execute("SEND");
	}

	/**
	 * Sending Batch Transactional Email through PostmarkApp
	 *
	 * @param array $messages PostMarkMessageArray An array of PostMarkMessage instances
	 *
	 * @return string
	 */
	public function sendBatch($messages)
	{
		foreach ($messages as $message) {
			if ($message instanceof PostMarkMessage) {
				$this->_send_object[] = $this->getMailObject($message);
			}
		}

		return $this->execute("BATCH");
	}

	/**
	 * Gets a prepared array object to send to PostMarkApp
	 *
	 * @param PostMarkMessage $postMarkMessage
	 *
	 * @return array
	 * @throws \Exception
	 */
	private function getMailObject(PostMarkMessage $postMarkMessage)
	{
		$messageObject = array();
		$from          = $postMarkMessage->getFrom();
		if (empty($from))
			throw new \Exception("Sender Information is not provided");
		else
			$messageObject['From'] = $from;

		$recipient = $postMarkMessage->getRecipient();
		if (empty($recipient))
			throw new \Exception("Recipient Information is not provided");
		else
			$messageObject['To'] = implode(",", $recipient);

		$cc = $postMarkMessage->getCC();
		if (!empty($cc)) {
			$messageObject['Cc'] = implode(",", $cc);
		}

		$bcc = $postMarkMessage->getBCC();
		if (!empty($bcc)) {
			$messageObject['Bcc'] = implode(",", $bcc);
		}

		$subject = $postMarkMessage->getSubject();
		if (empty($subject))
			throw new \Exception("Email Subject is not provided");
		else
			$messageObject['Subject'] = $subject;

		$tag = $postMarkMessage->getTag();
		if (!empty($tag)) {
			$messageObject['Tag'] = $tag;
		}

		$html_content = $postMarkMessage->getHtml();
		if (empty($html_content))
			throw new \Exception("The Html Content for the email is not provided");
		else
			$messageObject['HtmlBody'] = $html_content;

		$text_content = $postMarkMessage->getText();
		if (!empty($text_content))
			$messageObject['TextBody'] = $text_content;

		$replyTo = $postMarkMessage->getReplyTo();
		if (!empty($replyTo))
			$messageObject["ReplyTo"] = $replyTo;

		$headers = $postMarkMessage->getHeaders();
		if (!empty($headers))
			$messageObject["Headers"] = $headers;

		return $messageObject;
	}

	/**
	 * Performs the API Call to PostMarkApp using GuzzlePHP
	 *
	 * @param $type
	 *
	 * @return string
	 */
	private function execute($type)
	{
		$client = new Client($this->_api_url);
		$client->setDefaultOption("headers",
			array(
				'X-Postmark-Server-Token' => $this->_credentials,
				'Accept'                  => 'application/json',
				'Content-Type'            => ' application/json'
			));
		$url = "";
		switch ($type) {
			case "SEND":
				$url = $this->_api_send_url;
				break;
			case "BATCH":
				$url = $this->_api_batch_url;
		}
		$request = $client->post($url, null, json_encode($this->_send_object));

		return $request->send()->json();
	}
}