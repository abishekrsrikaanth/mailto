###Laravel 4 Package to integrate with multiple Cloud Email Providers

Email Providers

- [Mandrill](https://mandrillapp.com)

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

#####Work in progress

- PostmarkApp

#####Implementation for future

- MailGun
- ElasticMail
