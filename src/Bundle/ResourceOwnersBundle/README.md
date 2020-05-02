# ResourceOwnersBundle
Provides login user management for Symfony3 Project.

## Configuration

In app/AppKernel.php, add following lines
```php
public function registerBundles()
{
    $bundles = [

        // ...

        new MMC\User\Bundle\ResourceOwners\MMCResourceOwnersBundle(),
        new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),

        // ...
    ];

    // ...
}
```

For configuration of HWIOAuthBundle, see [HWIOAuthBundle documentation](https://github.com/hwi/HWIOAuthBundle/blob/master/Resources/doc/index.md)).

Add your resource owners class :
```yaml
# app/config/config.yml
mmc_resource_owners:
    resource_owners_class: AppBundle\Entity\ResourceOwners
```

Add route :
```yaml
# app/config/routing.yml
mmc_user_resources_owners:
   resource: "@MMCResourceOwnersBundle/Resources/config/routing.yml"
```
