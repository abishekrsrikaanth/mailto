####Email Providers Supported
- [Installation](#install)
- [Mandrill](https://www.mandrillapp.com) - ([Documentation](#mandrill))
  - [Sending Email using Mandrill](#send-mandrill)
  - [Queuing Email using Mandrill](#queue-mandrill)
  - [Sending Email at a given Time](#send-mandrill-time)
  - [Sending Email to a Batch of recipients](#send-mandrill-batch)
  - [Sending Email to a Batch of recipients at a given time](#send-mandrill-batch-time)
  - [Passing the credentials dynamically for Mandrill](#credentials-mandrill)
  - [Methods](#methods-mandrill)
- [PostmarkApp](http://www.postmarkapp.com) - In Progress

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
Publish Configuration
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

####Sending Email at a given Time<a name="send-mandrill-time"></a>
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

####Sending Email to a Batch of recipients<a name="send-mandrill-batch"></a>
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->sendBatch();
```

####Sending Email to a Batch of recipients at a given time<a name="send-mandrill-batch-time"></a>
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

####Passing the credentials dynamically for Mandrill<a name="credentials-mandrill"></a>
```
$mandrill = MailTo::Mandrill(array('apikey'=>'MADRILL_API_KEY'));
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

####Example Response from Mandrill - Success
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

####Example Response from Mandrill - Error
```
{
    "status": "error",
    "code": 10,
    "name": "PaymentRequired",
    "message": "This feature is only available for accounts with a positive balance."
}
```
####Methods<a name="methods-mandrill"></a>
<table>
  <tr>
    <th>Method</th><th>Explanation</th>
  </tr>
  <tr>
    <td>Mandrill($credentials)</td>
    <td>Constructor will initialize the API Key. If no credentials is passed, the credentials will be picked from the config file</td>
  </tr>
  <tr>
    <td>addRecipient($email,$name)</td>
    <td>Adds a Recipient for the Email. Multiple Recipients can be added by calling this function again</td>
  </tr>
  <tr>
    <td>setHtml($html)</td>
    <td>Sets the HTML Content for the Email</td>
  </tr>
  <tr>
    <td>setText($text)</td>
    <td>Sets the Text Content for the Email</td>
  </tr>
  <tr>
    <td>setSubject($subject)</td>
    <td>Sets the Subject of the Email</td>
  </tr>
  <tr>
    <td>setFrom($email, $name)</td>
    <td>Set the Information of the Sender. Calling this function again will override the information if already called</td>
  </tr>
  <tr>
    <td>setGlobalMergeVariables($key, $value)</td>
    <td>Set the Global merge variables to use for all recipients. Call this function multiple times to add multiple items.</td>
  </tr>
  <tr>
    <td>setMergeVariables($recipient, $key, $value)</td>
    <td>Set per-recipient merge variables, which override global merge variables with the same name. Call this function multiple times to add multiple items.</td>
  </tr>
  <tr>
    <td>setGlobalMetadata($key, $value)</td>
    <td>Set user metadata. Mandrill will store this metadata and make it available for retrieval. 
    In addition, you can select up to 10 metadata fields to index and make searchable using the Mandrill search api.</td>
  </tr>
  <tr>
    <td>setMetadata($recipient, $key, $value)</td>
    <td>Set Per-recipient metadata that will override the global values specified in the metadata parameter.</td>
  </tr>
  <tr>
    <td>setReplyTo($email)</td>
    <td>Sets the Reply To Email Address</td>
  </tr>
  <tr>
    <td>addAttachment($fileName, $mime, $content)</td>
    <td>Adds an Attachment to the Email. Can be called multiple times to add multiple attachments. The content has to be base64encoded</td>
  </tr>
  <tr>
    <td>addImage($fileName, $mime, $content)</td>
    <td>Adds an Image to the Email. Can be called multiple times to add multiple images.</td>
  </tr>
  <tr>
    <td>isImportant($value)</td>
    <td>Marking the Email whether or not this message is important, and should be delivered ahead of non-important messages. false by default</td>
  </tr>
  <tr>
    <td>shouldTrackOpens($value)</td>
    <td>Sets whether or not to turn on open tracking for the message. false by default</td>
  </tr>
  <tr>
    <td>shouldTrackClicks($value)</td>
    <td>Sets whether or not to turn on click tracking for the message. false by default</td>
  </tr>
  <tr>
    <td>shouldAutoText($value)</td>
    <td>Sets whether or not to automatically generate a text part for messages that are not given text. false by default</td>
  </tr>
  <tr>
    <td>shouldAutoHtml($value)</td>
    <td>Sets whether or not to automatically generate an HTML part for messages that are not given HTML. false by default</td>
  </tr>
  <tr>
    <td>shouldStripUrlQS($value)</td>
    <td>Sets whether or not to strip the query string from URLs when aggregating tracked URL data. false by default</td>
  </tr>
  <tr>
    <td>setInlineCSS($value)</td>
    <td>Sets whether or not to automatically inline all CSS styles provided in the message HTML - only for HTML documents less than 256KB in size. false by default</td>
  </tr>
  <tr>
    <td>setBccAddress($value)</td>
    <td>Sets an optional address to receive an exact copy of each recipient's email</td>
  </tr>
  <tr>
    <td>setTrackingDomain($value)</td>
    <td>Sets a custom domain to use for tracking opens and clicks instead of mandrillapp.com</td>
  </tr>
  <tr>
    <td>setSigningDomain($value)</td>
    <td>Sets a custom domain to use for SPF/DKIM signing instead of mandrill (for "via" or "on behalf of" in email clients)</td>
  </tr>
    <tr>
    <td>addTags($value)</td>
    <td>Sets a Tag to the Email. Can be called repeatedly to add multiple tags</td>
  </tr>
  <tr>
    <td>send($timestamp)</td>
    <td>Send a new transactional message through Mandrill. If multiple recipients have been added, they will be show on the `To` field of the Email
    If parameter timestamp is specified, then it marks a message to be sent later. If you specify a time in the past, the message will be sent immediately.
    An additional fee applies on Mandrill for scheduled email, and this feature is only available to accounts with a positive balance.
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
    </td>
  </tr>
</table>
#####Work in progress

- PostmarkApp

#####Implementations coming soon

- MailGun
- ElasticMail
- PostageApp
- Mad Mimi
- Alpha Mail
