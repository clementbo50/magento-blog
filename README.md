# magento-blog
Découverte Magento2 (2.4.5)

## 1ère étape : Création d'un module & de notre première table
Source : https://www.youtube.com/watch?v=vkhijbeTZOg&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=1
### Étapes à suivre :

1. **Créer le répertoire du module** :
   - Ouvrez votre terminal et exécutez la commande suivante pour créer le répertoire du module :
     ```bash
     mkdir -p app/code/MageMastery/Blog
     ```

2. **Créer le fichier `registration.php`** :
   - Créez un fichier nommé `registration.php` dans le répertoire `app/code/MageMastery/Blog` avec le contenu suivant :
     ```php
     <?php 
     declare(strict_types=1);
     use Magento\Framework\Component\ComponentRegistrar;

     ComponentRegistrar::register(
         ComponentRegistrar::MODULE, // Type d'enregistrement, ici un module
         'MageMastery_Blog', // Nom du module
         __DIR__ // Chemin du répertoire du module
     );
     ```

3. **Créer le fichier `etc/module.xml`** :
   - Créez un fichier nommé `module.xml` dans le répertoire `app/code/MageMastery/Blog/etc` avec le contenu suivant :
     ```xml
     <?xml version="1.0"?>
     <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
         <module name="MageMastery_Blog" setup_version="1.0.0"/>
     </config>
     ```

4. **Activer le module** :
   - Exécutez la commande suivante pour activer le module que vous venez de créer :
     ```bash
     php bin/magento module:enable MageMastery_Blog
     ```

5. **Mettre à jour la base de données** :
   - Exécutez la commande suivante pour mettre à jour la base de données et appliquer les modifications :
     ```bash
     php bin/magento setup:upgrade
     ```
   - **Remarque** : Assurez-vous que le service Elasticsearch est en cours d'exécution avant d'exécuter cette commande.

6. **Créer le fichier `etc/db_schema.xml`** :
   - Créez un fichier nommé `db_schema.xml` dans le répertoire `app/code/MageMastery/Blog/etc` pour définir la structure de la table de posts de blog. Voici un exemple de contenu :
     ```xml
     <?xml version="1.0" encoding="UTF-8"?>
     <schema xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
             xsi:noNamespaceSchemaLocation="urn:magento:framework:Setup/Declaration/Schema/etc/schema.xsd">
         <table name="magemastery_blog_post" resource="default" engine="innodb" comment="MageMastery Blog Post table">
             <column xsi:type="smallint" name="post_id" unsigned="false" nullable="false" identity="true"/>
             <column xsi:type="varchar" name="title" nullable="true" length="255" comment="titre du post"/>
             <column xsi:type="text" name="meta_keywords" nullable="true" comment="mots clés du post"/>
             <column xsi:type="text" name="meta_description" nullable="true" comment="description du post"/>
             <column xsi:type="mediumtext" name="content" nullable="true" comment="contenu du post"/>
             <constraint xsi:type="primary" referenceId="PRIMARY">
                 <column name="post_id"/>
             </constraint>
         </table>
     </schema>
     ```

## 2ème étape : Création du modèle et du modèle de ressource
Source : https://www.youtube.com/watch?v=b9wadgeJ_rw&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=2
### Étapes à suivre :

1. **Créer le fichier `Model/Post.php`** :
   - Créez un fichier nommé `Post.php` dans le répertoire `app/code/MageMastery/Blog/Model` avec le contenu suivant :
     ```php
     <?php

     declare(strict_types=1);

     namespace MageMastery\Blog\Model;

     use Magento\Framework\Model\AbstractModel;
     use MageMastery\Blog\Model\ResourceModel\Post as PostResource;

     class Post extends AbstractModel
     {
         // La méthode _construct est appelée lors de la création d'une instance de la classe Post
         protected function _construct()
         {
             // Initialise le modèle en liant la classe Post à sa ressource correspondante (PostResource)
             $this->_init(PostResource::class);
         }
     }
     ```

2. **Créer le fichier `Model/ResourceModel/Post.php`** :
   - Créez un fichier nommé `Post.php` dans le répertoire `app/code/MageMastery/Blog/Model/ResourceModel` avec le contenu suivant :
     ```php
     <?php

     declare(strict_types=1);

     namespace MageMastery\Blog\Model\ResourceModel;

     use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

     class Post extends AbstractDb 
     {
         private const TABLE_NAME = 'magemastery_blog_post';
         private const PRIMARY_KEY = 'post_id';

         protected function _construct()
         {
             $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
         }
     }
     ```

3. **Créer le fichier `Model/ResourceModel/Post/Collection.php`** :
   - Créez un fichier nommé `Collection.php` dans le répertoire `app/code/MageMastery/Blog/Model/ResourceModel/Post` avec le contenu suivant :
     ```php
     <?php

     declare(strict_types=1);

     namespace MageMastery\Blog\Model\ResourceModel\Post;

     use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
     use MageMastery\Blog\Model\Post;
     use MageMastery\Blog\Model\ResourceModel\Post as PostResource;

     class Collection extends AbstractCollection
     {
         // La méthode _construct est appelée lors de la création d'une instance de la collection
         protected function _construct()
         {
             // Initialise la collection en liant le modèle Post à son modèle de ressource PostResource
             $this->_init(Post::class, PostResource::class);
         }
     }
     ```

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

## Conclusion étape 2 :
Ce module permet de gérer les posts de blog dans Magento de manière structurée et efficace, en séparant la logique métier, la persistance des données et la gestion des collections.


