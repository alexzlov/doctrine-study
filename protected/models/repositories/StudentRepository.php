<?php

use Doctrine\ORM\Tools\Pagination\Paginator;

class StudentRepository extends YDBaseRepository
{
    protected $_perPage = 10;

    protected $_id = 'StudentRepository';

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
        if ($itemNumber) {
            $this->_perPage = $itemNumber;
        }
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
        $dql = "SELECT s FROM Student s ORDER BY s.id";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(($pageNumber - 1) * $this->getPerPage())
            ->setMaxResults($this->getPerPage());
        $paginator = new Paginator($query, $fetchJoinCollections = true);
        $output = array();
        foreach ($paginator as $student) {
            array_push($output, array(
                'name' => $student->getName(),
                'studentCount' => count($student->getTeachers())
            ));
        }
        return $output;
    }
}