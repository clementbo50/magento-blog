# magento-blog
Découverte Magento2 tuto : "https://www.youtube.com/watch?v=vkhijbeTZOg&amp;list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor"


## 1ere étape : Création d'un module & de notre première table
url youtube : "https://www.youtube.com/watch?v=vkhijbeTZOg&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor"
1. Créer le répertoire app/code/MageMastery/Blog 
2. Créer le fichier registration.php
3. Créer le fichier etc/module.xml
4. Activé le module qu'on vient de créer php bin/magento module:enable MageMastery_Blog
5. Mettre à jour la base de données php bin/magento setup:upgrade (Attention : ne pas oublier de lancer elasticsearch, et de bien renommer le fichier db_schema.xml)

## 2eme étape : Création de notre modèle Post
url youtube : https://www.youtube.com/watch?v=b9wadgeJ_rw&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=2

## Modèle Post
La classe `Post` représente un post de blog dans Magento. Elle gère la logique métier associée à un post, tout en étant liée à son modèle de ressource pour les opérations de base de données.

### Fonctionnalités :
- **Héritage** : Hérite de `AbstractModel`, ce qui permet d'utiliser les méthodes de base pour la gestion des données.
- **Méthode `_construct()`** : Initialise le modèle en liant la classe `Post` à sa ressource correspondante (`PostResource`).

## Modèle de Ressource Post
La classe `Post` dans le dossier `ResourceModel` gère l'interaction avec la base de données pour le modèle `Post`.

### Fonctionnalités :
- **Héritage** : Hérite de `AbstractDb`, ce qui permet de gérer les opérations de base de données.
- **Constantes** : Définit le nom de la table (`magemastery_blog_post`) et la clé primaire (`post_id`).
- **Méthode `_construct()`** : Initialise la ressource en liant la classe à la table et à la clé primaire.

## Collection de Posts
La classe `Collection` gère les collections de modèles `Post`, permettant de récupérer plusieurs posts de la base de données.

### Fonctionnalités :
- **Héritage** : Hérite de `AbstractCollection`, ce qui permet de gérer des collections de modèles.
- **Méthode `_construct()`** : Initialise la collection en liant la classe `Collection` au modèle `Post` et à sa ressource `PostResource`.

## Conclusion
Ce module permet de gérer les posts de blog dans Magento de manière structurée et efficace, en séparant la logique métier, la persistance des données et la gestion des collections.


