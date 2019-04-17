<?php
namespace App\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Liip\ImagineBundle\LiipImagineBundle;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber {

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploaderHelper
     */
    private $uploaderHelper;

    // j'injecte les class dans le construct pour gérer la gestion de cache
    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    // je retourne les events (entité modifiée ou ajoutée)
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'prepdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Property)
        {
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }


    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        // if (!$args->getEntity() instanceof Property)
        if (!$entity instanceof Property)
        {
            return;
        }
        if ($entity->getImageFile() instanceof UploadedFile );
        {   
            // if de type uploaderfile je reproduit la logique this->cachemanager remove, jutilise uploaederhelper 
            //que je sauvegarde dans $entity avec le parametre imageFile
            $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}