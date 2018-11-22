# module-searchmodified
This Module is use to search string and find modified files.

## ✓ Install via composer (recommend)
Run the following command in Magento 2 root folder:

```
composer require ashish-wagento/module-searchmodified
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

### Search Content

It is very easy to search content, search content in specific directory. 

| Parameter  | Value  | Required? |
| :------------ |:---------------| :-----|
| --string | Enter string to search e.g. AccountController | Yes
| --dir  | Directory path e.g. app/code/ | No
| --ext  | File extensions, Enter file extensions. e.g. php / For multiple file types e.g. php,phtml | No

Run the following command in Magento 2 root folder:

```
php bin/magento wagento:search  --string='<module name='  --dir=app/code --ext=xml,php
```

**Output**
![](docs/images/search.png)

### Search Modified Files

This feature is useful to search the modified files within the folder.

| Parameter  | Value  | Required? |
| :------------ |:---------------| :-----|
| --days | Number Of Days | Yes
| --dir  | Directory path e.g. app/code/ | No
| --ext  | File extensions, Enter file extensions. e.g. php / For multiple file types e.g. php,phtml | No

Run the following command in Magento 2 root folder:

```
 php bin/magento wagento:modified  --days=10 --dir=app/code --ext=php
```

**Output**
![](docs/images/modified.png)

> Note: To search today's modified files you can set parameter like --days=0