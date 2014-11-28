#MelodiaPageBundle

##Installation

Step 1: Download the Bundle
---------------------------

```json
// composer.json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/melodia/MelodiaPageBundle.git"
  }
]
```

```bash
$ composer require "melodia/page-bundle" "dev-master"
```

Step 2: Enable the Bundle
-------------------------

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Sonata\BlockBundle\SonataBlockBundle(),
            new Melodia\PageBundle\MelodiaPageBundle(),
        );

        // ...
    }

    // ...
}
```

Step 3: Configure dependencies of the Bundle
------------------------------------------------

```yaml
# app/config/parameters.yml

sonata_block:
    default_contexts: [cms]
    blocks:
        sonata.block.service.text:
        melodia.block.service.menu:

# Common configuration for all Melodia API bundles

nelmio_api_doc: ~

jms_serializer:
    metadata:
        auto_detection: true
    property_naming:
        separator:  ~
        lower_case: false

fos_rest:
    param_fetcher_listener: force
    view:
        view_response_listener: force
        jsonp_handler: ~
    serializer:
        serialize_null: true
    routing_loader:
        default_format: json
        include_format: false
    format_listener:
      rules:
        - { path: '^/api', priorities: ['json'] }
        - { path: '^/', priorities: ['html'] }

stof_doctrine_extensions:
    orm:
        default:
            softdeleteable: true
```

Step 4: Import API router
-------------------------

```yaml
# app/config/routing.yml

melodia_page_api_:
    resource: "@MelodiaPageBundle/Resources/config/routing/api.yml"
    prefix:   /api
```
