<?php
declare(strict_types=1);

namespace MageMastery\Blog\Model;

// Importation de la classe AbstractModel de Magento
use Magento\Framework\Model\AbstractModel;
// Importation du modèle de ressource associé
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
