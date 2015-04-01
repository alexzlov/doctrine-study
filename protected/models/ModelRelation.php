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
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="studentRelations")
     * @ORM\JoinColumn(name="teacherId", referencedColumnName="id")
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="teacherRelations")
     * @ORM\JoinColumn(name="studentId", referencedColumnName="id")
     */
    private $student;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Teacher $teacher
     * @return ModelRelation
     */
    public function setTeacher(Teacher $teacher)
    {
        $this->teacher = $teacher;
        return $this;
    }

    /**
     * @return Teacher
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * @param Student $student
     * @return ModelRelation
     */
    public function setStudent(Student $student)
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }
}