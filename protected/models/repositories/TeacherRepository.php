<?php

use Doctrine\ORM\Tools\Pagination\Paginator;

class TeacherRepository extends YDBaseRepository
{
    protected $_perPage = 1;

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
        $dql = "SELECT t FROM Teacher t ORDER BY t.id";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(($pageNumber - 1) * $this->getPerPage())
            ->setMaxResults($this->getPerPage());
        $paginator = new Paginator($query, $fetchJoinCollection = true);;
        $output = array();
        foreach ($paginator as $teacher) {
            array_push($output, array(
                'id' => $teacher->getId(),
                'name' => $teacher->getName(),
                'studentCount' => count($teacher->getStudents())
            ));
        }
        return array(
            'itemCount' => $paginator->count(),
            'data'      => $output,
        );
    }

    public function studentsAssigned($teacherId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $data = $qb->select('s')
            ->from('Student', 's')
            ->where($qb->expr()->in(
                's.id',
                $this->getEntityManager()->createQueryBuilder()->select('r.studentId')
                    ->from('ModelRelation', 'r')
                    ->where('r.teacherId='.$teacherId)->getDQL()
            ));
        $data = $data->getQuery()->getArrayResult();
        return $data;
    }

    public function studentsNotAssigned($teacherId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $data = $qb->select('s')
            ->from('Student', 's')
            ->where($qb->expr()->notIn(
                's.id',
                $this->getEntityManager()->createQueryBuilder()->select('r.studentId')
                ->from('ModelRelation', 'r')
                ->where('r.teacherId='.$teacherId)->getDQL()
        ));
        $data = $data->getQuery()->getArrayResult();
        return $data;
    }
}