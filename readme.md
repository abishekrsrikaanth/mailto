####Email Providers Supported
- [Installation](#install)
- [Mandrill](https://www.mandrillapp.com) - ([Documentation](#mandrill))
  - [Sending Email using Mandrill](#send-mandrill)
  - [Queuing Email using Mandrill](#queue-mandrill)
  - [Sending Email at a given Time](#send-mandrill-time)
  - [Sending Email to a Batch of recipients](#send-mandrill-batch)
  - [Sending Email to a Batch of recipients at a given time](#send-mandrill-batch-time)
  - [Passing the credentials dynamically for Mandrill](#credentials-mandrill)
  - [Managing Webhooks](#mandrill-webhooks)
  - [Methods](#methods-mandrill)
- [PostmarkApp](http://www.postmarkapp.com)
  - [Sending Email using PostMark](#send-postmark)
  - [Sending Batch Emails using PostMark](#send-postmark-batch)

###Installation<a name="install"></a>
Add abishekrsrikaanth/mailto as a requirement to composer.json:
```
{
    ...
    "require": {
        ...
        "abishekrsrikaanth/mailto": "dev-master"
        ...
    },
}
```
Update composer:
```
$ php composer.phar update
```
Add the provider to your app/config/app.php:
```
'providers' => array(
    ...
    'Abishekrsrikaanth\Mailto\MailtoServiceProvider',
),
```
and the Facade info on app/config/app.php
```
'aliases'   => array(
    ...
	'MailTo'      => 'Abishekrsrikaanth\Mailto\Facades\Mailto',
),
```
Publish the Configuration and setup the config with the credentials of the different email providers
```
php artisan config:publish abishekrsrikaanth/mailto
```

###Mandrill
<a name="mandrill"></a>
#####Sending Email using Mandrill <a name="send-mandrill"></a>
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

#####Queuing Email using Mandrill<a name="queue-mandrill"></a>
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->queue();
```

#####Sending Email at a given Time<a name="send-mandrill-time"></a>
```
$timestamp = new DateTime('+1 hour');

$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send($timestamp);
```

#####Sending Email to a Batch of recipients<a name="send-mandrill-batch"></a>
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->sendBatch();
```

#####Sending Email to a Batch of recipients at a given time<a name="send-mandrill-batch-time"></a>
```
$timestamp = new DateTime('+1 hour');

$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->sendBatch($timestamp);
```

#####Passing the credentials dynamically for Mandrill<a name="credentials-mandrill"></a>
```
$mandrill = MailTo::Mandrill(array('apikey'=>'MADRILL_API_KEY'));
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

#####Example Response from Mandrill - Success
```
[
    {
        "email": "recipient.email@example.com",
        "status": "sent",
        "reject_reason": "hard-bounce",
        "_id": "abc123abc123abc123abc123abc123"
    }
]
```

#####Example Response from Mandrill - Error
```
{
    "status": "error",
    "code": 10,
    "name": "PaymentRequired",
    "message": "This feature is only available for accounts with a positive balance."
}
```

#####Managing Webhooks<a name="mandrill-webhooks"></a>
The configuration of this package allows you to configure the webhooks that have been created on the mandrill control panel.
When enabled and configured, the necessary routes for the web hooks are automatically created and is ready to implement.
The details of enabling and configuring the web hooks are mentioned below.

```
'mandrill' => array(
		'apikey'    => 'MANDRILL_API_TOKEN',
		'web_hooks' => array(
			'enabled' => false,
			'routes'  => array(
				array(
					'route_url'   => '/mandrill/send',
					'route_types' => array('send'),
					'webhook_key' => 'API_WEBHOOK_KEY',
					'listener'    => array(
						'type' => 'event',
						'name' => ''
					),
					'verify_hook' => false
				),
				array(
					'route_url'   => '/mandrill/bounce',
					'route_types' => array(''),
					'webhook_key' => '',
					'listener'    => array(
						'type' => 'queue',
						'name' => ''
					),
					'verify_hook' => false
				)
			)
		)
	)
```

<dl>
  <dt>web_hooks.enabled</dt>
  <dd>Indicates whether to enable or disable the configuration of web hooks</dd>

  <dt>web_hooks.routes</dt>
  <dd>An array of route configurations that you wish to define for various event types of mandrill</dd>
</dl>

Lets look at detail the route configurations.

<dl>
  <dt>routes.route_url</dt>
  <dd>The route URL of the webhook. On the example above it is configured as <strong>/mandrill/send</strong>, the route will be configured to <strong>http://base_url/mandrill/send</strong></dd>

  <dt>routes.route_types</dt>
  <dd>An array object that contains the list of events that have been configured for this web hook. 
  You would have done this when setting up the web hook on the Mandrill Control Panel. 
  The different event types are listed on http://help.mandrill.com/entries/21738186-Introduction-to-Webhooks. 
  This configuration will only be used if verify_hook is set to true</dd>
  
  <dt>routes.webhook_key</dt>
  <dd>A key that is automatically generated when a webhook is created. 
  This can be found on the Webhook Control panel of mandrill. Every Webhook has a different key generated.
  Again, this configuration will only be used if verify_hook is set to true</dd>
  
  <dt>routes.listener</dt>
  <dd>The listener is used to configure a hook on the application to listen to when the webhook is called. 
  There are 2 listeners that you can configure. <strong>Event</strong>, <strong>Queue</strong>.
  The <strong>type</strong> takes the type of listener that you want to configure it to [event, queue].
  The <strong>name</strong> takes the name of the listener that should be called. 
  A look at the Laravel docs on how to setup an Event Listener or Queue will help understand.
  </dd>
  
  <dt>routes.verify_hook</dt>
  <dd>It takes a boolean value and notifies the route to verify the web hook call. 
  There are 2 verfications that are done here <br/>
  a. Mandrill sends an encrypted signature based on the data and the key of the webhook that can be used to verify if the web hook call is actually coming from Mandrill.
  <br/>
  b. It checks if the event type matches the web_hook call. <br/><br/>
  Setting the configuration to <strong>true</strong> will automatically start validating the web hook calls if the calls are from Mandrill or not.
  No additional coding required</dd>
</dl>
#####Methods<a name="methods-mandrill"></a>
<table>
  <tr>
    <th>Method</th><th>Explanation</th>
  </tr>
  <tr>
    <td>Mandrill($credentials)</td>
    <td>Constructor will initialize the API Key. If no credentials is passed, the credentials will be picked from the config file
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	            <td>$credentials</td>
	            <td>array</td>
	            <td>array('apikey'=>'API_KEY_GOES_HERE')</td>
	 	</tr>
	 </table>
    </td>
  </tr>
  <tr>
    <td>addRecipient($email,$name)</td>
    <td>Adds a Recipient for the Email. Multiple Recipients can be added by calling this function again
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	            <td>$email</td>
	            <td>string</td>
	            <td>john@doe.com</td>
	 	</tr>
	 	<tr>
	            <td>$name</td>
	            <td>string</td>
	            <td>John Doe</td>
	 	</tr>
	 </table>
    </td>
  </tr>
  <tr>
    <td>setHtml($html)</td>
    <td>Sets the HTML Content for the Email
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$html</td>
	             <td>string</td>
	             <td>&lt;strong&gt;Hi *|user_name|*, This is the body of the message. There is also a global merge tag *|website_url|*&lt;/strong&gt;</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setText($text)</td>
    <td>Sets the Text Content for the Email
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$text</td>
	             <td>string</td>
	             <td>This is the Text Content of the message</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setSubject($subject)</td>
    <td>Sets the Subject of the Email
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$subject</td>
	             <td>string</td>
	             <td>This is the subject of the email</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setFrom($email, $name)</td>
    <td>Set the Information of the Sender. Calling this function again will override the information if already called
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$email</td>
	             <td>string</td>
	             <td>sam@supernatural.com</td>
	        </tr>
	        <tr>
	        	<td>$name</td>
	        	<td>string</td>
	        	<td>Sam Winchester</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setGlobalMergeVariables($key, $value)</td>
    <td>Set the Global merge variables to use for all recipients. Call this function multiple times to add multiple items.
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$key</td>
	             <td>string</td>
	             <td>website_url</td>
	        </tr>
	        <tr>
	        	<td>$value</td>
	        	<td>string</td>
	        	<td>http://wwww.google.com</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setMergeVariables($recipient, $key, $value)</td>
    <td>Set per-recipient merge variables, which override global merge variables with the same name. 
    Call this function multiple times to add multiple items.
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$recipient</td>
	             <td>string</td>
	             <td>john@john-doe.com</td>
	        </tr>
	        <tr>
	        	<td>$key</td>
	        	<td>string</td>
	        	<td>user_name</td>
	        </tr>
	        <tr>
	        	<td>$content</td>
	        	<td>string</td>
	        	<td>Joh Doe</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setGlobalMetadata($key, $value)</td>
    <td>Set user metadata. Mandrill will store this metadata and make it available for retrieval. 
    In addition, you can select up to 10 metadata fields to index and make searchable using the Mandrill search api.
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$key</td>
	             <td>string</td>
	             <td>INVITE</td>
	        </tr>
	        <tr>
	        	<td>$value</td>
	        	<td>string</td>
	        	<td>MEMBER</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setMetadata($recipient, $key, $value)</td>
    <td>Set Per-recipient metadata that will override the global values specified in the metadata parameter.
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$recipient</td>
	             <td>string</td>
	             <td>john@john-doe.com</td>
	        </tr>
	        <tr>
	             <td>$key</td>
	             <td>string</td>
	             <td>INVITE</td>
	        </tr>
	        <tr>
	        	<td>$value</td>
	        	<td>string</td>
	        	<td>US-MEMBER</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setReplyTo($email)</td>
    <td>Sets the Reply To Email Address
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$email</td>
	             <td>string</td>
	             <td>john@john-doe.com</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>addAttachment($fileName, $mime, $content)</td>
    <td>Adds an Attachment to the Email. Can be called multiple times to add multiple attachments. The content has to be base64encoded
	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$fileName</td>
	             <td>string</td>
	             <td>test-file.txt</td>
	        </tr>
	        <tr>
	        	<td>$mime</td>
	        	<td>string</td>
	        	<td>application/text</td>
	        </tr>
	        <tr>
	        	<td>$content</td>
	        	<td>string</td>
	        	<td>ZXhhbXBsZSBmaWxl</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>addImage($fileName, $mime, $content)</td>
    <td>Adds an Image to the Email. Can be called multiple times to add multiple images.
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$fileName</td>
	             <td>string</td>
	             <td>test-file.png</td>
	        </tr>
	        <tr>
	        	<td>$mime</td>
	        	<td>string</td>
	        	<td>image/png</td>
	        </tr>
	        <tr>
	        	<td>$content</td>
	        	<td>string</td>
	        	<td>ZXhhbXBsZSBmaWxl</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>isImportant($value)</td>
    <td>Marking the Email whether or not this message is important, and should be delivered 
    head of non-important messages. false by default
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
	</td>
  </tr>
  <tr>
    <td>shouldTrackOpens($value)</td>
    <td>Sets whether or not to turn on open tracking for the message. false by default
        <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>shouldTrackClicks($value)</td>
    <td>Sets whether or not to turn on click tracking for the message. false by default
        <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
      </td>
  </tr>
  <tr>
    <td>shouldAutoText($value)</td>
    <td>Sets whether or not to automatically generate a text part for messages that are not given text. 
    false by default
        <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>shouldAutoHtml($value)</td>
    <td>Sets whether or not to automatically generate an HTML part for messages that are not given HTML. 
    false by default
    	<table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
     </td>
  </tr>
  <tr>
    <td>shouldStripUrlQS($value)</td>
    <td>Sets whether or not to strip the query string from URLs when aggregating tracked URL data. 
    false by default
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setInlineCSS($value)</td>
    <td>Sets whether or not to automatically inline all CSS styles provided in the message HTML 
    - only for HTML documents less than 256KB in size. false by default
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>boolean</td>
	             <td>true</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setBccAddress($value)</td>
    <td>Sets an optional address to receive an exact copy of each recipient's email
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>string</td>
	             <td>john@john-doe.com</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setTrackingDomain($value)</td>
    <td>Sets a custom domain to use for tracking opens and clicks instead of mandrillapp.com
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>string</td>
	             <td>john-doe.com</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>setSigningDomain($value)</td>
    <td>Sets a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$value</td>
	             <td>string</td>
	             <td>john-doe.com</td>
	        </tr>
	</table>
    </td>
  </tr>
    <tr>
    <td>addTags($value)</td>
    <td>Sets a Tag to the Email. Can be called repeatedly to add multiple tags
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$tag</td>
	             <td>string</td>
	             <td>password-resets</td>
	        </tr>
	</table>
    </td>
  </tr>
  <tr>
    <td>send($timestamp)</td>
    <td>Send a new transactional message through Mandrill. If multiple recipients have been added, they will be show on the `To` field of the Email
    If parameter timestamp is specified, then it marks a message to be sent later. If you specify a time in the past, the message will be sent immediately.
    An additional fee applies on Mandrill for scheduled email, and this feature is only available to accounts with a positive balance.
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th>Example</th>
	        </tr>
	        <tr>
	             <td>$timestamp</td>
	             <td>DateTime</td>
	             <td>new DateTime('+1 hour')</td>
	        </tr>
	</table>
    </td>
  </tr>
    <tr>
    <td>queue()</td>
    <td>Enables background sending mode that is optimized for bulk sending.
    In async mode, messages/send will immediately return a status of "queued" for every recipient.
    To handle rejections when sending in async mode, set up a webhook for the 'reject' event.
    Defaults to false for messages with no more than 10 recipients;
    messages with more than 10 recipients are always sent asynchronously, regardless of the value of async.</td>
  </tr>
  <tr>
    <td>sendBatch($timestamp)</td>
    <td>Sends the email as a batch to Multiple Recipients.
    If parameter timestamp is specified, then it marks a message to be sent later. 
    If you specify a time in the past, the message will be sent immediately.
    An additional fee applies on Mandrill for scheduled email, and this feature is only available to accounts with a positive balance.
    <table>
    		<tr>
	            <th>Parameter</th><th>Type</th><th></th>
	        </tr>
	        <tr>
	             <td>$timestamp</td>
	             <td>DateTime</td>
	             <td>new DateTime('+1 hour');</td>
	        </tr>
	</table>
    
    </td>
  </tr>
</table>

###PostMarkApp

#####Sending Email <a name="send-postmark"></a>
```
$postMark = MailTo::PostMark();
$message  = $postMark->getMessageInstance();
$message->addRecipient("RECIPIENT_EMAIL")
	->setFrom("FROM_EMAIL", "FROM_NAME")
	->setSubject("EMAIL_SUBJECT")
	->setHtml("HTML_CONTENT_GOES_HERE")
	->setText("TEXT_CONTENT_GOES_HERE");
$postMark->send($message);
```

#####Example Response from Postmark for Send Method if Message sent successfully
```
{
  "ErrorCode" : 0,
  "Message" : "OK",
  "MessageID" : "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
  "SubmittedAt" : "2010-11-26T12:01:05.1794748-05:00",
  "To" : "receiver@example.com"
}
```

#####Sending Batch Email <a name="send-postmark-batch"></a>
```
$postMark = MailTo::PostMark();
$message  = $postMark->getMessageInstance();
$message->addRecipient("RECIPIENT_EMAIL")
    ->setFrom("FROM_EMAIL", "FROM_NAME")
	->setSubject("EMAIL_SUBJECT")
	->setHtml("HTML_CONTENT_GOES_HERE")
	->setText("TEXT_CONTENT_GOES_HERE");
$postMark->send($message);
```

#####Example Response from Postmark for Send Method if Message sent successfully
```
[
    {
      "ErrorCode" : 0,
      "Message" : "OK",
      "MessageID" : "b7bc2f4a-e38e-4336-af7d-e6c392c2f817",
      "SubmittedAt" : "2010-11-26T12:01:05.1794748-05:00",
      "To" : "receiver1@example.com"
    },
    {
      "ErrorCode" : 0,
      "Message" : "OK",
      "MessageID" : "e2ecbbfc-fe12-463d-b933-9fe22915106d",
      "SubmittedAt" : "2010-11-26T12:01:05.1794748-05:00",
      "To" : "receiver2@example.com"
    }
]
```


#####Work in progress

- ElasticMail

#####Implementations coming soon

- MailGun

- PostageApp
- Mad Mimi
- Alpha Mail

[![endorse](https://api.coderwall.com/abishekrsrikaanth/endorsecount.png)](https://coderwall.com/abishekrsrikaanth)
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/abishekrsrikaanth/mailto/trend.png)](https://bitdeli.com/free "Bitdeli Badge")
