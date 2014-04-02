SeoSAFeedbackBundle
===================

Features:
--------------
- Provides feedback interface

Installation:
--------------

### Step 1: Download SeoSAFeedbackBundle using composer

Add SeoSAFeedbackBundle in your composer.json:

```js
{
    "require": {
        "seosa/feedback-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update seosa/feedback-bundle
```

Composer will install the bundle to your project's `seosa/feedback-bundle` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\RestBundle\FOSRestBundle(),
        new JMS\SerializerBundle\JMSSerializerBundle($this),
        new SeoSA\FeedbackBundle\SeoSAFeedbackBundle(),
        // ...
    );
}
```

### Step 3: Create you own message class

#### Anonymous
``` php
// src/Acme/FeedbackBundle/Entity/FeedbackMessage.php
namespace Acme\FeedbackBundle\Entity;

**
 * Class Acme\FeedbackBundle\Entity\FeedbackMessage
 *
 * @ORM\Entity
 */
class FeedbackMessage extends Message
{
}
```

#### Or signed
``` php
// src/Acme/FeedbackBundle/Entity/FeedbackMessage.php
namespace Acme\FeedbackBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

**
 * Class Acme\FeedbackBundle\Entity\FeedbackMessage
 *
 * @ORM\Entity
 */
class FeedbackMessage extends Message implements SignedMessageInterface
{
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Acme\FeedbackBundle\EntityUser", cascade={"remove"})
     */
    protected $author;

    /**
     * @param UserInterface|null $user
     *
     * @return $this
     */
    public function setAuthor(UserInterface $user = null)
    {
        $this->author = $user;

        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
```

### Step 4: Import SeoSAFeedbackBundle routing

In YAML somthing like:

``` yaml
# app/config/routing.yml

seo_sa_feedback:
    type: rest
    resource: @SeoSAFeedbackBundle/Resources/config/routing.yml
    prefix: /feedback
    defaults: {_format: 'html'}
```

### Step 5: Add minimal configuration

``` yaml
# app/config/config.yml

seo_sa_feedback:
    message:
        class: Acme\FeedbackBundle\Entity\FeedbackMessage
```

### Step 6: Add bundle into assetic
``` yaml
# app/config/config.yml

assetic:
    ....
    bundles: ['SeoSAFeedbackBundle']
```

### Step final: Add button or panel into your template
``` twig
{# Add a button #}

{% include 'SeoSAFeedbackBundle:Feedback:button.html.twig' %}
```

``` twig
{# Add a panel #}

{% include 'SeoSAFeedbackBundle:Feedback:async-panel.html.twig' %}
```


## Optional:

### Override templates
``` yaml
# app/config/config.yml

seo_sa_feedback:
    ....
    templating:
        layout:               'AcmeFeedbackBundle::feedback-layout.html.twig'
        message_show:         'AcmeFeedbackBundle:FeedbackMessage:show.html.twig'
        message_form:         'AcmeFeedbackBundle:FeedbackMessage:form.html.twig'
        message_list:         'AcmeFeedbackBundle:FeedbackMessage:list.html.twig'
```

### Enable SonataAdminIntegration
``` yaml
# app/config/config.yml

seo_sa_feedback:
    ....
    sonata_admin:
        enabled:              true
        group:                YouSonataAdminGroup
        label:                YouSonataAdminTitle
```