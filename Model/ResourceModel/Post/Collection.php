<?php

declare(strict_types=1);

namespace MageMastery\Blog\Model\ResourceModel\Post;

// Importation de la classe de collection abstraite de Magento
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
// Importation du modèle Post
use MageMastery\Blog\Model\Post;
// Importation du modèle de ressource Post
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

