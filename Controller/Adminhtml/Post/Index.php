<?php
declare(strict_types=1);

namespace MageMastery\Blog\Controller\Adminhtml\Post;

// Import des classes nécessaires de Magento
use Magento\Backend\App\Action;                    // Classe de base pour les contrôleurs admin
use Magento\Framework\App\Action\HttpGetActionInterface;  // Interface pour les requêtes GET
use Magento\Framework\Controller\ResultFactory;    // Factory pour créer les objets de résultat
use Magento\Backend\Model\View\Result\Page;       // Classe pour gérer les pages d'administration

/**
 * Contrôleur pour la page d'index des posts dans l'admin
 * 
 * Ce contrôleur gère l'affichage de la grille des posts dans l'interface d'administration
 * Il étend Action pour avoir accès aux fonctionnalités de base des contrôleurs admin
 * Il implémente HttpGetActionInterface car c'est une page accessible en GET
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Point d'entrée du contrôleur
     * 
     * Cette méthode est appelée quand on accède à la route magemastery_blog/post/index
     * 
     * @return Page L'objet Page qui sera rendu par Magento
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        // Création d'une nouvelle page via la factory
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        // Définit quel menu doit être actif dans la navigation admin
        $resultPage->setActiveMenu('MageMastery_Blog::posts');

        // Définit le titre de la page dans l'admin
        $resultPage->getConfig()->getTitle()->prepend(__('Poste du blog'));

        // Retourne la page qui sera affichée
        return $resultPage;
    }
}