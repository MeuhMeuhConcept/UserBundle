[![Build Status](https://travis-ci.org/mdeblaise/UserBundle.svg?branch=master)](https://travis-ci.org/mdeblaise/UserBundle)
# UserBundle
Provides user management for Symfony3 Project.

## Installation

Via composer
```bash
composer require meuhmeuhconcept/user-bundle
```

## Configuration

In app/AppKernel.php, add following lines
```php
public function registerBundles()
{
    $bundles = [

        // ...

        new MMC\User\Bundle\UserBundle\MMCUserBundle()

        // ...
    ];

    // ...
}
```

Add mmc user security configuration :
```yaml
# app/config/security.yml
    encoders:
        MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator: bcrypt

    providers:
        mmc_user:
            entity: { class: MMC\User\Bundle\UserBundle\Entity\LoginFormAuthenticator, property: email }

    firewalls:
        main:
            guard:
                authenticators:
                    - mmc_user.component.security.login_form_authenticator
            
            anonymous: ~

            logout:
                path: /logout
```

Add mmc user route :
```yaml
# app/config/routing.yml
mmc_user:
    resource: "@MMCUserBundle/Resources/config/routing.yml"
```

## Customization

If you need a design layout, you should use the default design layout :
```yaml
# app/config/config.yml
    mmc_user:
        templates:
            layout: MMCUserBundle:Default:layout.html.twig
```

You can use your custom layout, for that replace mmc default layout by your custom layout:
```yaml
# app/config/config.yml
    mmc_user:
        templates:
            layout: AppBundle:Default:myCustomLayout.html.twig
```

For implement remember me in the template :
```yaml
# app/config/config.yml
    mmc_user:
        templates:
            remember_me: true
```

Add remember me functionnality in security configuration:
```yaml
# app/config/security.yml
    firewalls:
        main:
            
            #/----
            
            remember_me:
                secret:   '%secret%'
                lifetime: 604800 # 1 week in seconds

            #/----
```
