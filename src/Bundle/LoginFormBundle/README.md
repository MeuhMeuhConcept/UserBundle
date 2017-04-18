# LoginBundle
Provides login user management for Symfony3 Project.

## Configuration

In app/AppKernel.php, add following lines
```php
public function registerBundles()
{
    $bundles = [

        // ...

        new MMC\User\Bundle\LoginBundle\MMCLoginBundle()

        // ...
    ];

    // ...
}
```

Add mmc user security configuration :
```yaml
# app/config/security.yml
    encoders:
        MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator: bcrypt

    providers:
        mmc_user:
            entity: { class: MMC\User\Bundle\LoginBundle\Entity\LoginFormAuthenticator, property: email }

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

For enable registration :
```yaml
# app/config/config.yml
    mmc_login:
        registration: true
```

For enable forgot password :
```yaml
# app/config/config.yml
    mmc_login:
        forgot_password: true
```
