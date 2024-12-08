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
   - Exécutez la commande suivante pour installer le module sur le système :
     ```bash
     php bin/magento setup:upgrade
     ```


5. **Créer le fichier `etc/db_schema.xml`** :
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

6. **Mettre à jour la base de données** :
   - Exécutez la commande suivante pour mettre à jour la base de données et appliquer les modifications :
     ```bash
     php bin/magento setup:upgrade
     ```
   - **Remarque** : Assurez-vous que le service Elasticsearch est en cours d'exécution avant d'exécuter cette commande.

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

## Explication du Modèle Post
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

## 3ème étape : Gestion d'un CRUD simple avec ObjectManager

Source : https://www.youtube.com/watch?v=8vPNq8tB6oc&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=4

Dans cette étape, nous allons voir comment gérer les opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) pour nos entités de posts de blog en utilisant l'ObjectManager de Magento. Cela nous permettra d'interagir facilement avec notre modèle de données (attention c'est un exemple de CRUD simple habituellement on ne doit pas modifier le fichier `pub/index.php` comme cela !).

### Étapes à suivre :

1. **Utiliser le fichier `pub/index.php` pour le CRUD** :
   - Dans le fichier `pub/index.php`, nous allons implémenter les opérations CRUD. Voici un exemple de code à ajouter :
     ```php
     <?php
     // ... code d'initialisation de Magento ... 
     // ne pas oublié de commenter $bootstrap->run($app);

     $om = $bootstrap->getObjectManager(); // Récupère le gestionnaire d'objets

     /** @var MageMastery\Blog\Model\ResourceModel\Post $postResource */
     $postResource = $om->get(MageMastery\Blog\Model\ResourceModel\Post::class);

     // --- Créer un nouveau post ---
     $post = $om->create(MageMastery\Blog\Model\Post::class);
     $post->setData([
         'title' => 'Mon premier post',
         'meta_keywords' => 'magento 2, blog, post',
         'meta_description' => 'Description de mon premier post',
         'content' => '<p>Contenu de mon premier post</p>'
     ]);
     $postResource->save($post);
     echo "<h2>Post créé :</h2>";
     echo "<pre style='background-color: #f0f0f0; padding: 10px;'>" . var_export($post->getData(), true) . "</pre>";

     // --- Lire tous les posts ---
     $collection = $om->get(MageMastery\Blog\Model\ResourceModel\Post\Collection::class);
     echo "<h2>Liste des posts :</h2>";
     foreach ($collection->getItems() as $post) {
         echo "<pre style='background-color: #e0f7fa; padding: 10px;'>" . var_export($post->getData(), true) . "</pre>";
     }

     // --- Mettre à jour un post ---
     $postToUpdate = $collection->getFirstItem();
     $postToUpdate->setData('title', 'Mon post mis à jour');
     $postResource->save($postToUpdate);
     echo "<h2>Post mis à jour :</h2>";
     echo "<pre style='background-color: #ffe0b2; padding: 10px;'>" . var_export($postToUpdate->getData(), true) . "</pre>";

     // --- Supprimer un post ---
     $postToDelete = $collection->getLastItem();
     $postResource->delete($postToDelete);
     echo "<h2>Post supprimé :</h2>";
     echo "<pre style='background-color: #ffccbc; padding: 10px;'>" . var_export($postToDelete->getData(), true) . "</pre>";
     ```

### Explication du code :

- **Initialisation de Magento** : Le fichier commence par initialiser l'environnement Magento en incluant le fichier `bootstrap.php`. Cela permet d'accéder à toutes les fonctionnalités de Magento.

- **Création d'un nouveau post** : On crée une nouvelle instance du modèle `Post`, on définit ses données, puis on l'enregistre dans la base de données.

- **Lecture des posts** : On récupère tous les posts de la collection et on les affiche. Chaque post est stylisé pour une meilleure lisibilité.

- **Mise à jour d'un post** : On récupère le premier post de la collection, on modifie son titre, puis on l'enregistre à nouveau.

- **Suppression d'un post** : On récupère le dernier post de la collection et on le supprime. Les données du post supprimé sont affichées.

### Remarques :
- Assurez-vous que le module est activé et que la base de données est à jour avant d'exécuter ce code.


## Conclusion étape 3 :
Cette étape vous a montré comment gérer les opérations CRUD de manière simple et efficace en utilisant l'ObjectManager de Magento. Cela vous permet de manipuler vos entités de manière fluide et intégrée dans l'écosystème Magento.

## 4ème étape : Création d'une page d'administration

Source : https://www.youtube.com/watch?v=FT_z5Vc9ZxE&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=5

Dans cette étape, nous allons créer une interface d'administration pour gérer les posts du blog. Cela implique la création de plusieurs fichiers pour configurer les routes, le menu et le contrôleur.

### Étapes à suivre :

1. **Créer le fichier `etc/adminhtml/routes.xml`** :
   - Ce fichier définit les routes pour l'administration :
     ```xml
     <?xml version="1.0"?>
     <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
             xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
         <router id="admin">
             <route id="magemastery_blog" frontName="magemastery_blog">
                 <module name="MageMastery_Blog" before="Magento_Backend" />
             </route>
         </router>
     </config>
     ```

2. **Créer le fichier `etc/adminhtml/menu.xml`** :
   - Ce fichier configure le menu dans l'interface d'administration :
     ```xml
     <?xml version="1.0"?>
     <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
             xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Backend:etc/menu.xsd">
         <menu>
             <add id="MageMastery_Blog::content_elements" 
                  title="Mage Mastery Blog" 
                  translate="title"
                  module="MageMastery_Blog"
                  sortOrder="10"
                  parent="Magento_Backend::content"
                  resource="Magento_Backend::admin"/>
             
             <add id="MageMastery_Blog::posts"
                  title="Posts" 
                  translate="title"
                  module="MageMastery_Blog"
                  sortOrder="0"
                  parent="MageMastery_Blog::content_elements"
                  action="magemastery_blog/post"
                  resource="Magento_Backend::admin"/>
         </menu>
     </config>
     ```

3. **Créer le contrôleur `Controller/Adminhtml/Post/Index.php`** :
   - Ce fichier gère l'affichage de la page d'administration des posts :
     ```php
     <?php
     declare(strict_types=1);

     namespace MageMastery\Blog\Controller\Adminhtml\Post;

     use Magento\Backend\App\Action;
     use Magento\Framework\App\Action\HttpGetActionInterface;
     use Magento\Framework\Controller\ResultFactory;
     use Magento\Backend\Model\View\Result\Page;

     class Index extends Action implements HttpGetActionInterface
     {
         public function execute(): Page
         {
             /** @var Page $resultPage */
             $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
             $resultPage->setActiveMenu('MageMastery_Blog::posts');
             $resultPage->getConfig()->getTitle()->prepend(__('Poste du blog'));
             return $resultPage;
         }
     }
     ```

### Explication des fichiers :

#### Routes (routes.xml)
- Définit la route `magemastery_blog` pour l'administration
- Le `frontName` sera utilisé dans l'URL de l'admin
- Le module est chargé avant `Magento_Backend` pour assurer la compatibilité

#### Menu (menu.xml)
- Crée deux entrées dans le menu admin :
  1. Un menu parent "Mage Mastery Blog" sous "Contenu"
  2. Un sous-menu "Posts" qui pointe vers notre contrôleur
- Définit les permissions et l'ordre d'affichage

#### Contrôleur (Index.php)
- Gère l'affichage de la page principale des posts
- Utilise le système de pages admin de Magento
- Configure le menu actif et le titre de la page
- Retourne une page d'administration complète

### Activation des modifications :

Après avoir créé ces fichiers, exécutez la commande suivante :
```bash
php bin/magento cache:clean

```

### Accès à l'interface d'administration :
- Connectez-vous à l'admin Magento
- Dans le menu principal, sous "Contenu", vous trouverez "Mage Mastery Blog"
- Cliquez sur "Posts" pour accéder à la gestion des posts

## Conclusion étape 4 :
cette étape nous a permis de créer une page d'administration pour notre module de blog.

## 5ème étape : Création de la grille d'administration

Source : https://www.youtube.com/watch?v=4kvQqVKgcTc&list=PLwcl8DqLMv9e4j7NETVpbG2BtBkqsxeor&index=5

Dans cette étape, nous allons créer une grille d'administration pour afficher et gérer les posts du blog de manière plus efficace. Cette grille utilisera le composant UI de Magento 2.

### Fichiers créés/modifiés :

1. **Layout XML (`view/adminhtml/layout/magemastery_blog_post_index.xml`)** :
   ```xml
   <?xml version="1.0"?>
   <page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
         xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
       <body>
           <referenceContainer name="content">
               <uiComponent name="magemastery_blog_post_listing" />
           </referenceContainer>
       </body>
   </page>
   ```
   Ce fichier définit la structure de la page d'administration et intègre notre composant UI.


2. **Créer le fichier `etc/adminhtml/magemastery_blog_post_listing.xml`** :
   (voir le code dans le fichier `etc/adminhtml/magemastery_blog_post_listing.xml`)

   ce fichier configure la grille d'administration pour notre module.

3. **Configuration de l'injection de dépendances (`etc/di.xml`)** :
   ```xml
   <?xml version="1.0"?>
   <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
           xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
       <type name="Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory">
           <arguments>
               <argument name="collections" xsi:type="array">
                   <item name="magemastery_blog_post_listing_data_source" xsi:type="string">MageMastery\Blog\Model\ResourceModel\Post\Grid\Collection</item>
               </argument>
           </arguments>
       </type>
       <type name="MageMastery\Blog\Model\ResourceModel\Post\Grid\Collection">
           <arguments>
               <argument name="mainTable" xsi:type="string">magemastery_blog_post</argument>
               <argument name="eventPrefix" xsi:type="string">magemastery_blog_post_grid_collection</argument>
               <argument name="eventObject" xsi:type="string">magemastery_blog_post_collection</argument>
               <argument name="resourceModel" xsi:type="string">MageMastery\Blog\Model\ResourceModel\Post</argument>
           </arguments>
       </type>
   </config>
   ```
   Ce fichier configure la source de données pour notre grille.

3. **Collection pour la grille (`Model/ResourceModel/Post/Grid/Collection.php`)** :
   Cette classe étend la collection de base des posts et implémente les interfaces nécessaires pour le composant UI :
   - Gestion des agrégations
   - Conversion des dates
   - Implémentation de SearchResultInterface
   - Configuration des filtres et du tri

(voir le code dans le fichier `Model/ResourceModel/Post/Grid/Collection.php`)



### Fonctionnalités de la grille :

- **Affichage des données** : Liste tous les posts du blog avec leurs informations
- **Filtrage** : Permet de filtrer les posts selon différents critères
- **Tri** : Possibilité de trier les colonnes
- **Pagination** : Navigation entre les pages de résultats
- **Actions en masse** : Permet d'effectuer des actions sur plusieurs posts à la fois
- **Recherche** : Recherche textuelle dans les posts
- **Colonnes personnalisables** : L'utilisateur peut choisir quelles colonnes afficher

### Configuration de la grille :

Le fichier `magemastery_blog_post_listing.xml` définit :
- La structure des colonnes
- Les filtres disponibles
- Les actions possibles
- La configuration de la pagination
- Les options de tri
- Les actions en masse
- La barre d'outils (toolbar)

### Remarques importantes :

1. La grille utilise le système de composants UI de Magento 2
2. Les données sont chargées de manière asynchrone via AJAX
3. La configuration est extensible et personnalisable
4. Les performances sont optimisées grâce au chargement à la demande

### Activation des modifications :

Après avoir ajouté ces fichiers, exécutez :
```bash
php bin/magento cache:clean
```

La grille d'administration est maintenant accessible via le menu Admin > Contenu > Mage Mastery Blog > Posts.


