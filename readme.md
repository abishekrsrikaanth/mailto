###Laravel 4 Package to integrate with multiple Cloud Email Providers

####Email Providers Supported

- [Mandrill](https://www.mandrillapp.com) - ([Documentation](#mandrill))
- [PostmarkApp](http://www.postmarkapp.com)

###Mandrill
<a name="mandrill">
#####Sending Email using Mandrill
```
$mandrill = MailTo::Mandrill();
$mandrill->AddRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

#####Queuing Email using Mandrill
```
$mandrill = MailTo::Mandrill();
$mandrill->AddRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->queue();
```

####Sending Email at a given Time
```
$mandrill = MailTo::Mandrill();
$mandrill->AddRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->sendLater();
```

####Passing the credentials dynamically for Mandrill
```
$mandrill = MailTo::Mandrill(array('apikey'=>'MADRILL_API_KEY'));
$mandrill->AddRecipient($email, $name)
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
