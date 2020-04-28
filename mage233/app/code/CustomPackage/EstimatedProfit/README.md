The CustomPackage_EstimatedProfit module will calculates estimated profit by (SalesPrice - Cost)*qty and display in catalog product's grid.

This module can be installed as below two ways :

1) Module .zip can be extracted in the app/code directory of magento.

->Then you need to fire below command that will install module.

php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento clean:cache

sudo chmod -R 777 var pub generated

2) By composer :

composer require custompackage/module-estimated-profit:1.0.0
