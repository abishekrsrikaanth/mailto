<?php

namespace Abishekrsrikaanth\Mailto\Providers\PostMark;

class PostMarkMessage
{
	private $_recipient = array();
	private $_from;
	private $_subject;
	private $_html;
	private $_text;
	private $_headers = array();
	private $_attachments = array();
	private $_inline_attachments = array();
	private $_cc = array();
	private $_bcc = array();
	private $_tag;
	private $_replyTo;

	/**
	 * Adds a Recipient to the Email Message
	 * @param $email
	 *
	 * @return $this
	 */public function addRecipient($email)
	{
		$this->_recipient[] = $email;

		return $this;
	}

	/**
	 * Gets the Recipients for the Message
	 * @return array
	 */public function getRecipient()
	{
		return $this->_recipient;
	}

	/**
	 * Adds the Sender Information
	 * @param        $email
	 * @param string $name
	 * @return $this
	 */public function setFrom($email, $name = "")
	{
		if (empty($name))
			$this->_from = $email;
		else {
			if (!empty($email)) {
				$this->_from = "$name <$email>";
			}
		}

		return $this;
	}

	/**
	 * Gets the sender Information
	 * @return mixed
	 */public function getFrom()
	{
		return $this->_from;
	}

	/**
	 * Sets the Subject for the Message
	 * @param $value
	 * @return $this
	 */public function setSubject($value)
	{
		$this->_subject = $value;

		return $this;
	}

	/**
	 * Gets the Subject for the Message
	 * @return mixed
	 */public function getSubject()
	{
		return $this->_subject;
	}

	/**
	 * Sets the HTML Content for the message
	 * @param $content
	 * @return $this
	 */public function setHtml($content)
	{
		$this->_html = $content;

		return $this;
	}

	/**
	 * Gets the HTML content for the message
	 * @return mixed
	 */public function getHtml()
	{
		return $this->_html;
	}

	/**
	 * Sets the Text Content for the message
	 * @param $content
	 * @return $this
	 */public function setText($content)
	{
		$this->_text = $content;

		return $this;
	}

	/**
	 * Gets the Text Content for the message
	 * @return mixed
	 */public function getText()
	{
		return $this->_text;
	}

	/**
	 * Adds and Entry to the Header of the Message
	 * @param $key
	 * @param $value
	 * @return $this
	 */public function addHeader($key, $value)
	{
		$this->_headers[] = array("Name" => $key, "Value" => $value);

		return $this;
	}

	/**
	 * Gets the Headers of the Message
	 * @return array
	 */public function getHeaders()
	{
		return $this->_headers;
	}

	/**
	 * Adds an Attachment to the message
	 * @param $name
	 * @param $type
	 * @param $content
	 * @return $this
	 */public function addAttachment($name, $type, $content)
	{
		$this->_attachments[] = array('Name' => $name, 'Content' => $content, 'ContentType' => $type);

		return $this;
	}

	/**
	 * Gets the Attachments of the message
	 * @return array
	 */public function getAttachments()
	{
		return $this->_attachments;
	}

	/**
	 * Adds an Inline Attachment to the message that can be used with the HTML Content
	 * @param $name
	 * @param $type
	 * @param $content
	 * @param $content_id
	 * @return $this
	 */public function addInlineAttachment($name, $type, $content, $content_id)
	{
		$this->_inline_attachments[] = array('Name' => $name, 'Content' => $content, 'ContentType' => $type, 'ContentID' => $content_id);

		return $this;
	}

	/**
	 * Gets all the Inline attachments of the message
	 * @return array
	 */public function getInlineAttachments()
	{
		return $this->_inline_attachments;
	}

	/**
	 * Adds a Carbon Copy Recipient to the Message
	 * @param $email
	 * @return $this
	 */public function addCC($email)
	{
		$this->_cc[] = $email;

		return $this;
	}

	/**
	 * Gets the Carbon Copy Recipients of the Message
	 * @return array
	 */public function getCC()
	{
		return $this->_cc;
	}

	/**
	 * Adds a Blind Carbon Copy Recipient to the Message
	 * @param $email
	 * @return $this
	 */public function addBCC($email)
	{
		$this->_bcc[] = $email;

		return $this;
	}

	/**
	 * Gets the Blind Copy Recipients of the Message
	 * @return array
	 */public function getBCC()
	{
		return $this->_bcc;
	}

	/**
	 * Sets a Tag to the Message
	 * @param $value
	 * @return $this
	 */public function setTag($value)
	{
		$this->_tag = $value;

		return $this;
	}

	/**
	 * Gets the Tag of the Message
	 * @return mixed
	 */public function getTag()
	{
		return $this->_tag;
	}

	/**
	 * Sets the Reply To Email to the Message
	 * @param $email
	 * @return $this
	 */public function setReplyTo($email)
	{
		$this->_replyTo = $email;

		return $this;
	}

	/**
	 * Gets the Reply To Email of the Message
	 * @return mixed
	 */public function getReplyTo()
	{
		return $this->_replyTo;
	}
}