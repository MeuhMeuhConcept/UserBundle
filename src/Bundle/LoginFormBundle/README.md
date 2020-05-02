# LoginFormBundle
Provides login user management for Symfony3 Project.

## Configuration

In app/AppKernel.php, add following lines
```php
public function registerBundles()
{
    $bundles = [

        // ...

        new MMC\User\Bundle\LoginFormBundle\MMCLoginFormBundle()

        // ...
    ];

    // ...
}
```

Add mmc user security configuration :
```yaml
# app/config/security.yml
    encoders:
        MMC\User\Bundle\LoginFormBundle\Entity\LoginFormAuthentication: bcrypt

    providers:
        mmc_login_provider:
            entity: { class: MMC\User\Bundle\LoginFormBundle\Entity\LoginFormAuthentication, property: login }

    firewalls:
        main:
            guard:
                authenticators:
                    - mmc_user.login_form.login_form_authenticator
            
            anonymous: ~

            logout:
                path: /logout
```

Add mmc user route :
```yaml
# app/config/routing.yml
mmc_user_login_form:
  resource: "@MMCLoginFormBundle/Resources/config/routing.yml"
```

Add your login form class :
```yaml
# app/config/config.yml
mmc_login_form:
    login_form_class: AppBundle\Entity\LoginFormAuthentication
```
