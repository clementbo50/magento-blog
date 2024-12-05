<?php 
// Déclaration stricte des types pour éviter les erreurs de type
declare(strict_types=1);

// Importation de la classe ComponentRegistrar de Magento
use Magento\Framework\Component\ComponentRegistrar;

// Enregistrement du module auprès de Magento
ComponentRegistrar::register(
    ComponentRegistrar::MODULE, // Type d'enregistrement, ici un module
    'MageMastery_Blog', // Nom du module
    __DIR__ // Chemin du répertoire du module
);
