<?php


class YDController  extends CController
{
    /**
     * @var Doctrine\ORM\EntityManager $entityManager
     */
    private $entityManager = null;

    /**
     * @return CHttpRequest
     */
    public function getRequest()
    {
        return Yii::app()->request;
    }

    /**
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (is_null($this->entityManager)) {
            $this->entityManager = Yii::app()->doctrine->getEntityManager();
        }
        return $this->entityManager;
    }

    /**
     * @return BaseRepository
     */
    public function getRepository()
    {
        $class = get_class($this);
        return $this->getEntityManager()->getRepository(
            substr($class, 0, (strlen($class) - 10))
        );
    }
}