###Laravel 4 Package to integrate multiple Email Providers

Email Providers

- Mandrill

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

Implementation in progress

- PostmarkApp

Implementation for future

- MailGun
- ElasticMail
