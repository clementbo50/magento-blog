<?php
declare(strict_types=1);
// Namespace de notre ressource Post
namespace MageMastery\Blog\Model\ResourceModel;
// Importation de la classe abstraite de Magento
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb 
{
    // Nom de la table
    private const TABLE_NAME = 'magemastery_blog_post';
    // Clé primaire
    private const PRIMARY_KEY = 'post_id';

    protected function _construct()
    {
        // Initialise la ressource en liant la table et la clé primaire
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}