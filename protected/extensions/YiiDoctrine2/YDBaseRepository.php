<?php

use Doctrine\ORM\EntityRepository;

abstract class YDBaseRepository extends EntityRepository implements IDataProvider
{
    protected $_id;

    private $_data;
    private $_keys;
    private $_totalItemCount;
    private $_sort;
    private $_pagination;
    private $_criteria;
    private $_countCriteria;

    public $modelClass;
    public $model;
    public $keyAttribute;

    abstract protected function fetchData();
    abstract protected function calculateTotalItemCount();

    public function getId() {}

    public function getPagination($className = 'CPagination') {}

    public function setPagination($value) {}

    public function setSort($value) {}

    public function getData($refresh = false) {}

    public function setData($refresh = false) {}

    public function getKeys($refresh = false) {}

    public function setKeys($value) {}

    public function getItemCount($refresh = false) {}

    public function getTotalItemCount($refresh = false) {}

    public function setTotalItemCount($value) {}

    public function getCriteria() {}

    public function setCriteria($value) {}

    public function getCountCriteria($value) {}

    public function setCountCriteria($value) {}

    public function getSort($className = 'CSort') {}

    protected function fetchKeys() {}

    private function _getSort($className) {}
}