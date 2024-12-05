# magento-blog
Découverte Magento2 tuto : "https://www.youtube.com/watch?v=vkhijbeTZOg&amp;list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor"


## 1ere étape : Création d'un module
url youtube : "https://www.youtube.com/watch?v=vkhijbeTZOg&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor"
1. Créer le répertoire app/code/MageMastery/Blog 
2. Créer le fichier registration.php
3. Créer le fichier etc/module.xml
4. Activé le module qu'on vient de créer php bin/magento module:enable MageMastery_Blog
5. Mettre à jour la base de données php bin/magento setup:upgrade (Attention : ne pas oublier de lancer elasticsearch, et de bien renommer le fichier db_schema.xml)



