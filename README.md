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

You can change main firewall (default : 'main') :
```yaml
# app/config/config.yml
    mmc_user:
        main_firewall: myFirewall

```