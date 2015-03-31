<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

Yii::import('YDController');
Yii::import('YDBaseRepository');

class YDComponent extends CApplicationComponent
{
    private $em = null;         // entity manager
    private $basePath;
    private $proxyPath;
    private $entityPath;
    private $db;

    public function init()
    {
        // Add alias path
        Yii::setPathOfAlias('Doctrine', $this->getBasePath() . '/vendor/doctrine');
        Yii::setPathOfAlias('Symfony', $this->getBasePath(). '/vendor/Symfony');

        // Init DoctrineORM
        $this->initDoctrine();

        parent::init();
    }

    public function initDoctrine()
    {
        $cache = new Doctrine\Common\Cache\FilesystemCache(
            $this->getBasePath() . '/../public/cache'
        );

        $config = Setup::createAnnotationMetadataConfiguration(
            $this->entityPath, true
        );

        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir($this->getProxyPath());
        $config->setProxyNamespace('Proxies');
        $config->setAutoGenerateProxyClasses(true);

        $this->em = EntityManager::create($this->db, $config);
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function setEntityPath($entityPath)
    {
        $this->entityPath = $entityPath;
    }

    public function getEntityPath()
    {
        return $this->entityPath;
    }

    public function setProxyPath($proxyPath)
    {
        $this->proxyPath = $proxyPath;
    }

    public function getProxyPath()
    {
        return $this->proxyPath;
    }

    public function setDb($info)
    {
        $this->db = $info;
    }

    public function getDb()
    {
        return $this->db;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}