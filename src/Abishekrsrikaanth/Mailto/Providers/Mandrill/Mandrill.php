<?php namespace Abishekrsrikaanth\Mailto\Providers\Mandrill;

use Abishekrsrikaanth\Mailto\Providers\ProviderInterface;
use Illuminate\Support\Facades\Config;
use Guzzle\Service\Client;

class Mandrill implements ProviderInterface
{
	private $_api_url = "https://mandrillapp.com/api/1.0/";

	private $_send_object = array();
	private $_global_merge_vars = array();
	private $_merge_vars = array();
	private $_global_metadata = array();
	private $_metadata = array();
	private $_recipients = array();
	private $_message_object = array();
	private $_api_send_url = 'messages/send.json';
	private $_attachments = array();
	private $_images = array();
	private $_tags = array();

	/**
	 * Constructor will initialize the API Key
	 */
	public function __construct($credentials = array())
	{
		if (count($credentials) > 0) {
			$api_key                  = $credentials['apikey'];
			$this->send_object['key'] = $api_key;
		} else {
			$api_key = Config::get("mailto::providers.mandrill.apikey");
			if (empty($api_key))
				throw new \Exception('The Mandrill API Key is missing');
			else
				$this->send_object['key'] = $api_key;
		}
	}

	/**
	 * Adds a Recipient for the Email. Multiple Recipients can be added by calling this function again
	 *
	 * @param $email
	 * @param $name
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function AddRecipient($email, $name)
	{
		if (empty($email) || empty($name))
			throw new \Exception('The Recipeint Email Address or Name is missing');
		else
			$this->_recipients[] = array('email' => $email, 'name' => $name);

		return $this;
	}

	/**
	 * Set the HTML Content for the Email
	 *
	 * @param $html
	 *
	 * @return $this
	 */
	public function setHtml($html)
	{
		$this->_message_object['html'] = empty($html) ? "" : $html;

		return $this;
	}

	/**
	 * Set the Text Content for the Email
	 *
	 * @param $text
	 *
	 * @return $this
	 */
	public function setText($text)
	{
		$this->_message_object['text'] = empty($text) ? "" : $text;

		return $this;
	}

	/**
	 * Set the Subject of the Email
	 *
	 * @param $subject
	 *
	 * @return $this
	 */
	public function setSubject($subject)
	{
		$this->_message_object['subject'] = empty($subject) ? "No Subject" : $subject;

		return $this;
	}

	/**
	 * Set the Senders details
	 *
	 * @param $email
	 * @param $name
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function setFrom($email, $name)
	{
		if (empty($email) || empty($name))
			throw new \Exception('The From Email Address or Name is missing');
		else {
			$this->_message_object['from_email'] = $email;
			$this->_message_object['from_name']  = $name;

			return $this;
		}
	}

	/**
	 * Set the Global merge variables to use for all recipients
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setGlobalMergeVariables($key, $value)
	{
		$this->_global_merge_vars[] = array($key, $value);

		return $this;
	}

	/**
	 * Set per-recipient merge variables, which override global merge variables with the same name
	 *
	 * @param $recipient
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setMergeVariables($recipient, $key, $value)
	{
		$this->_merge_vars[$recipient][] = array($key, $value);

		return $this;
	}

	/**
	 * Set user metadata. Mandrill will store this metadata and make it available for retrieval.
	 * In addition, you can select up to 10 metadata fields to index and make searchable
	 * using the Mandrill search api.
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setGlobalMetadata($key, $value)
	{
		$this->_global_metadata[] = array($key, $value);

		return $this;
	}

	/**
	 * Set Per-recipient metadata that will override the global values specified in the metadata parameter.
	 *
	 * @param $recipient
	 * @param $key
	 * @param $value
	 *
	 * @return $this
	 */
	public function setMetadata($recipient, $key, $value)
	{
		$this->_metadata[$recipient][] = array($key, $value);

		return $this;
	}

	/**
	 *Set the Reply To Email Address
	 *
	 * @param $email
	 *
	 * @return $this
	 */
	public function setReplyTo($email)
	{
		$this->_message_object['headers'] = array('Reply-To' => $email);

		return $this;
	}

	/**
	 * Adds an Attachment to the Email. Can be called multiple times to add multiple attachments.
	 *
	 * @param $fileName
	 * @param $mime
	 * @param $content
	 *
	 * @return $this
	 */
	public function AddAttachment($fileName, $mime, $content)
	{
		$this->_attachments[] = array('name' => $fileName, 'type' => $mime, 'content' => $content);

		return $this;
	}

	/**
	 * Adds an Image to the Email. Can be called multiple times to add multiple images.
	 *
	 * @param $fileName
	 * @param $mime
	 * @param $content
	 *
	 * @return $this
	 */
	public function AddImage($fileName, $mime, $content)
	{
		$this->_images[] = array('name' => $fileName, 'type' => $mime, 'content' => $content);

		return $this;
	}

	/**
	 * Marking the Email whether or not this message is important, and should be delivered ahead of non-important messages
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function isImportant($value = false)
	{
		$this->_message_object['important'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets whether or not to turn on open tracking for the message
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function shouldTrackOpens($value = false)
	{
		$this->_message_object['track_opens'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Set whether or not to turn on click tracking for the message
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function shouldTrackClicks($value = false)
	{
		$this->_message_object['track_clicks'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets whether or not to automatically generate a text part for messages that are not given text
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function shouldAutoText($value = false)
	{
		$this->_message_object['auto_text'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets whether or not to automatically generate an HTML part for messages that are not given HTML
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function shouldAutoHtml($value = false)
	{
		$this->_message_object['auto_html'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets whether or not to strip the query string from URLs when aggregating tracked URL data
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function shouldStringUrlQS($value = false)
	{
		$this->_message_object['url_strip_qs'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets whether or not to automatically inline all CSS styles provided in the message HTML
	 * - only for HTML documents less than 256KB in size
	 *
	 * @param bool $value
	 *
	 * @return $this
	 */
	public function setInlineCSS($value = false)
	{
		$this->_message_object['inline_css'] = $value == true ? true : false;

		return $this;
	}

	/**
	 * Sets an optional address to receive an exact copy of each recipient's email
	 *
	 * @param string $value
	 *
	 * @return $this
	 */
	public function setBccAddress($value = "")
	{
		if (!empty($value))
			$this->_message_object['bcc_address'] = $value;

		return $this;
	}

	/**
	 * Sets a custom domain to use for tracking opens and clicks instead of mandrillapp.com
	 *
	 * @param string $value
	 *
	 * @return $this
	 */
	public function setTrackingDomain($value = "")
	{
		if (!empty($value))
			$this->_message_object['tracking_domain'] = $value;

		return $this;
	}

	/**
	 * Sets a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
	 *
	 * @param string $value
	 *
	 * @return $this
	 */
	public function setSigningDomain($value = "")
	{
		if (!empty($value))
			$this->_message_object['signing_domain'] = $value;

		return $this;
	}

	/**
	 * Sets a Tag to the Email. Can be called repeatedly to add multiple tags
	 *
	 * @param $value
	 *
	 * @return $this
	 */
	public function addTags($value)
	{
		if (!empty($value))
			$this->_tags[] = $value;

		return $this;
	}

	/**
	 * Send a new transactional message through Mandrill
	 * If multiple recipients have been added, they will be show on the `To` field of the Email
	 *
	 * @return string
	 */
	public function send()
	{
		return $this->execute();
	}

	/**
	 * Marks a message to be sent later. If you specify a time in the past, the message will be sent immediately.
	 * An additional fee applies on Mandrill for scheduled email, and this feature is only available to accounts with a positive balance.
	 *
	 * @param $timestamp
	 *
	 * @return string
	 */
	public function sendLater($timestamp)
	{
		$this->_message_object['send_at'] = $timestamp;

		return $this->execute();
	}

	/**
	 * Enables background sending mode that is optimized for bulk sending.
	 * In async mode, messages/send will immediately return a status of "queued" for every recipient.
	 * To handle rejections when sending in async mode, set up a webhook for the 'reject' event.
	 * Defaults to false for messages with no more than 10 recipients;
	 * messages with more than 10 recipients are always sent asynchronously, regardless of the value of async.
	 *
	 * @return string
	 */
	public function queue()
	{
		$this->_message_object['async'] = true;

		return $this->execute();
	}

	/**
	 * Sends the email as a batch to Multiple Recipients.
	 *
	 * @return string
	 */
	public function batchSend()
	{
		$this->_message_object['preserve_recipients'] = false;
		$this->_message_object['async']               = true;

		return $this->execute();
	}

	/**
	 * Performs the API to Mandrill using GuzzlePHP
	 *
	 * @return string
	 */
	private function execute()
	{
		$client                                     = new Client($this->_api_url);
		$this->_message_object['to']                = $this->_recipients;
		$this->_message_object['global_merge_vars'] = $this->_global_merge_vars;
		$this->_message_object['merge_vars']        = $this->_merge_vars;
		$this->_send_object['message']              = $this->_message_object;
		$client->setUserAgent('PayToLibrary/0.1');
		$request = $client->post($this->_api_send_url, null, json_encode($this->_send_object));

		return $request->send()->json();
	}
}