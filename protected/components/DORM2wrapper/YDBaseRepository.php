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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $value
     */
    public function setId($value)
    {
        $this->_id = $value;
    }

    /**
     * @param string $className
     * @return CPagination|false
     */
    public function getPagination($className = 'CPagination')
    {
        if ($this->_pagination === null) {
            $this->_pagination = new $className;
            if (($id = $this->getId()) != '') {
                $this->_pagination->pageVar = $id . '_page';
            }
        }
        return $this->_pagination;
    }

    public function setPagination($value)
    {
        if (is_array($value)) {
            if (isset($value['class'])) {
                $pagination = $this->getPagination($value['class']);
                unset($value['class']);
            } else {
                $pagination = $this->getPagination();
            }

            foreach ($value as $k => $v) {
                $pagination->$k = $v;
            }
        } else {
            $this->_pagination = $value;
        }
    }

    /**
     * @param string $className
     * @return CSort|false
     */
    public function getSort($className = 'CSort')
    {
        if ($this->_sort === null) {
            $this->_sort = new $className;
            if (($id = $this->getId()) != '') {
                $this->_sort->sortVar = $id . '_sort';
            }
        }
        return $this->_sort;
    }

    /**
     * @param mixed $value
     */
    public function setSort($value)
    {
        if (is_array($value)) {
            if (isset($value['class'])) {
                $sort = $this->getSort($value['class']);
                unset($value['class']);
            } else {
                $sort = $this->getSort();
            }

            foreach ($value as $k => $v) {
                $sort->$k = $v;
            }
        } else {
            $this->_sort = $value;
        }
    }

    /**
     * @param bool $refresh
     * @return array
     */
    public function getData($refresh = false)
    {
        if ($this->_data === null || $refresh) {
            $this->_data = $this->fetchData();
        }
        return $this->_data;
    }

    /**
     * @param array $value
     */
    public function setData($value)
    {
        $this->_data = $value;
    }

    /**
     * @param bool $refresh
     * @return array
     */
    public function getKeys($refresh = false)
    {
        if ($this->_keys === null || $refresh) {
            $this->_keys = $this->fetchKeys();
        }
        return $this->_keys;
    }

    /**
     * @param array $value
     */
    public function setKeys($value)
    {
        $this->_keys = $value;
    }

    /**
     * @param bool $refresh
     * @return int
     */
    public function getItemCount($refresh = false)
    {
        return count($this->getData($refresh));
    }

    /**
     * @param bool $refresh
     * @return integer
     */
    public function getTotalItemCount($refresh = false)
    {
        if ($this->_totalItemCount === null || $refresh) {
            $this->_totalItemCount = $this->calculateTotalItemCount();
        }
        return $this->_totalItemCount;
    }

    /**
     * @param integer $value
     */
    public function setTotalItemCount($value)
    {
        $this->_totalItemCount = $value;
    }

    public function getCriteria() {}

    public function setCriteria($value) {}

    public function getCountCriteria($value) {}

    public function setCountCriteria($value) {}

    protected function fetchKeys()
    {
        $keys = array();
        foreach ($this->getData() as $i => $data) {
            $key = $this->keyAttribute === null ? $data->getPrimaryKey() : $data->{$this->keyAttribute};
            $keys[$i] = is_array($key) ? implode(',', $key) : $key;
        }
        return $keys;
    }
}