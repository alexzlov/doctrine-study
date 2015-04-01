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

    /**
     * @return array Associated teachers
     */
    protected $teacherRelations;

    public function __construct()
    {
        $this->teacherRelations = new DArrayCollection();
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

    public function addTeacherRelation(ModelRelation $relation)
    {
        $this->teacherRelations[] = $relation;
        return $this;
    }

    public function removeTeacherRelation(ModelRelation $relation)
    {
        $this->teacherRelations->removeElement($relation);
    }

    public function getTeacherRelations()
    {
        return $this->teacherRelations;
    }
}