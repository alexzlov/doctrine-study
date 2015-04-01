<?php

use Doctrine\ORM\Tools\Pagination\Paginator;

class TeacherRepository extends YDBaseRepository
{
    protected $_perPage = 10;

    protected $_id = 'TeacherRepository';

    /**
     * @return array
     */
    protected function fetchData()
    {

    }

    /**
     * @return integer
     */
    protected function calculateTotalItemCount()
    {

    }

    /**
     * @param integer $itemNumber
     */
    public function setPerPage($itemNumber)
    {
        if (!$itemNumber) return;
        $this->_perPage = $itemNumber;
    }

    /**
     * @return integer
     */
    public function getPerPage()
    {
        return $this->_perPage;
    }

    /**
     * @param int $pageNumber
     * @return Paginator
     */
    public function getAll($pageNumber = 1)
    {
        $dql = "SELECT t FROM Teacher t ORDER BY t.id";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(($pageNumber - 1) * $this->getPerPage())
            ->setMaxResults($this->getPerPage());
        $paginator = new Paginator($query, $fetchJoinCollection = true);
        return $paginator;
    }
}