###Laravel 4 Package to integrate with multiple Cloud Email Providers

####Email Providers Supported

- [Mandrill](https://www.mandrillapp.com)
- [PostmarkApp](http://www.postmarkapp.com)

####Sending Email using Mandrill
```
$mandrill = MailTo::Mandrill();
$mandrill->AddRecipient($email, $name)
         ->setFrom($email, $name)
         ->setHtml($html)
         ->setText($text)
         ->setSubject($subject)
         ->send();
```

####Queuing Email using Mandrill
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
#####Work in progress

- PostmarkApp

#####Implementation for future

- MailGun
- ElasticMail
