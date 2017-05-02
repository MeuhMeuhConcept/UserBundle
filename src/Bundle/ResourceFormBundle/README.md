# ResourceFormBundle
Provides login user management for Symfony3 Project.

## Configuration

In app/AppKernel.php, add following lines
```php
public function registerBundles()
{
    $bundles = [

        // ...

        new MMC\User\Bundle\ResourceFormBundle\MMCResourceFormBundle()

        // ...
    ];

    // ...
}
```

Add mmc user security configuration :
```yaml
# app/config/security.yml
    providers:
        mmc_resource_form_provider:
            entity: { class: MMC\User\Bundle\ResourceFormBundle\Entity\ResourceFormAuthentication }
    firewalls:
        main:
            guard:
                authenticators:
                    - mmc_user.email.guard.resource_form_authenticator.post
                    #OR                  - mmc_user.email.guard.resource_form_authenticator.get
                     if you need a GET method
            
            anonymous: ~

            logout:
                path: /logout
```

Add route :
```yaml
# app/config/routing.yml
mmc_user_resource_form:
   resource: "@MMCResourceFormBundle/Resources/config/routing.yml"
```

Add your resource form class :
```yaml
# app/config/config.yml
mmc_resource_form:
    resource_form_class: AppBundle\Entity\ResourceFormAuthentication
```

Configure your mode (email form with token url example) :
```yaml
# app/config/config.yml
mmc_resource_form:
    modes:    
        email_form_url:
            type: email
            form_type : MMC\User\Bundle\ResourceFormBundle\Form\EmailFormType
            block_template: MMCResourceFormBundle:Security\Block:email_block.html.twig
            message_subject: MonSuperMessage
            message_template: MMCResourceFormBundle:Security:resource_url.html.twig
            render_template: MMCResourceFormBundle:Security:check_email.html.twig
            registration_template: MMCResourceFormBundle:Security\Block:email_registration_block.html.twig
```
