# MessageBundle

AppKernel
---------

```php
<?php

public function registerBundles()
{
    $bundles = array(
        new KRG\MessageBundle\KRGMessageBundle()
    );
}
```


Configuration
-------------

```yaml
# app/config/config.yml

krg_message:
    class: KRG\MessageBundle\Service\Sender # default
    senders:
        mailer:
            helper: KRG\MessageBundle\Service\Helper\Mailer # default
            from: address@email.com
            bcc: 
                - address1@email.com
                - address2@email.com
```

Declare messages service
------------------------

```yaml
# app/config/service.yml

AppBundle\Message\:
    resource: '../../src/AppBundle/Message/*'
    lazy: true
    tags: [message.type]
```


Create a message
----------------

Step 1: create a Message class that extends AbstractMessage
```php
<?php

namespace AppBundle\Message;

use KRG\MessageBundle\Event\AbstractMessage;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Templating\EngineInterface;

class SampleEmail extends AbstractMessage
{
    public function getTo()
    {
        return $this->options['user']->getEmail();
    }

    public function getSubject()
    {
        return 'Sample Email';
    }

    public function getBody(EngineInterface $templating)
    {
        return $templating->render('messages/sample_email.html.twig', [
            'user' => $this->options['user'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(['user']);
        $resolver->setAllowedTypes('user', UserInterface::class);
    }
}
```

Step 2: create a twig template
```twig
{% extends '@KRGMessage/Default/mail.html.twig' %}

{% block content %}
    Hi {{ user.lastname }} {{ user.firstname }} !
{% endblock %}
```

Step 3: send it from anywhere
```php
<?php

$this->get(KRG\MessageBundle\Service\Factory\MessageFactory::class)
    ->create(AppBundle\Message\SampleEmail::class, ['user' => $user])
    ->send();
```
