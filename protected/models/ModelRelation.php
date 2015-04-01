<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher - Student Association
 *
 * @ORM\Table(name="sky_relation")
 * @ORM\Entity(repositoryClass="RelationRepository")
 */
class ModelRelation
{
    /**
     * var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(name="teacherId", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="studentRelations")
     * @ORM\JoinColumn(name="teacherId", referencedColumnName="id")
     */
    private $teacherId;

    /**
     * @ORM\Column(name="studentId", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="teacherRelations")
     * @ORM\JoinColumn(name="studentId", referencedColumnName="id")
     */
    private $studentId;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Teacher $teacherId
     * @return ModelRelation
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    /**
     * @return Teacher
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * @param Student $studentId
     * @return ModelRelation
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * @return Student
     */
    public function getStudentId()
    {
        return $this->studentId;
    }
}