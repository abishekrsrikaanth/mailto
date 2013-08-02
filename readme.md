###Laravel 4 Package to integrate with multiple Cloud Email Providers

####Email Providers Supported

- [Mandrill](https://www.mandrillapp.com) - ([Documentation](#mandrill))
- [PostmarkApp](http://www.postmarkapp.com)

###Installation
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
###Mandrill
<a name="mandrill"></a>
#####Sending Email using Mandrill
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

#####Queuing Email using Mandrill
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->queue();
```

####Sending Email at a given Time
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

####Sending Email to a Batch of recipients
```
$mandrill = MailTo::Mandrill();
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->sendBatch();
```

####Sending Email to a Batch of recipients at a given time
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

####Passing the credentials dynamically for Mandrill
```
$mandrill = MailTo::Mandrill(array('apikey'=>'MADRILL_API_KEY'));
$mandrill->addRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

#####Work in progress

- PostmarkApp

#####Implementations coming soon

- MailGun
- ElasticMail