<?php


class YDController  extends CController
{
    public $layout='//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();

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