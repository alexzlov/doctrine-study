<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DArrayCollection;

/**
 * Class Student
 *
 * @ORM\Table(name="sky_student")
 * @ORM\Entity(repositoryClass="StudentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Student extends CModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="sky_student")
     * @ORM\JoinTable(name="sky_relation",
     *      joinColumns={@ORM\JoinColumn(name="studentId", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="teacherId", referencedColumnName="id")}
     * )
     */
    private $teachers;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->teachers = new DArrayCollection();
    }

    public function attributeNames()
    {
        return array(
            'id'        => 'id',
            'name'      => 'name',
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'        => 'id',
            'name'      => 'Имя студента',
        );
    }

    public function addTeacher(ModelRelation $relation)
    {
        $this->teachers[] = $relation;
        return $this;
    }

    public function removeTeacher(ModelRelation $relation)
    {
        $this->teachers->removeElement($relation);
    }

    public function getTeachers()
    {
        return $this->teachers;
    }
}