# NoIndex NoFollow NoArchive Tag
NoIndex NoFollow NoArchive Tag extension

### Installation
- Composer:
```
composer require mage-os/meta-robots-tag
```

After installation, enable the module
```
bin/magento module:enable MageOS_MetaRobotsTag
```
upgrade your database:
```
bin/magento setup:upgrade
```
and compile the Magento dependency injection:
```
bin/magento setup:di:compile
```

### Usage
Now you can find 3 new attributes in the "Search Engine Optimization" section of products, categories and CMS Page

![img.png](img.png)

![img_1.png](img_1.png)

![img_2.png](img_2.png)

By enabling the flag in one of the options, the option will be forced to "no" for that entity

**Warning: if the option is not flagged, it does not mean that it will be forced to "yes", but default the configuration in the design settings will be used.**

![img_3.png](img_3.png)
