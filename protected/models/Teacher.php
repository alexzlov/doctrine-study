<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DArrayCollection;

/**
 * Class Teacher
 *
 * @ORM\Table(name="sky_teacher")
 * @ORM\Entity(repositoryClass="TeacherRepository")
 * @ORM\HasLifecycleCallbacks
 */

class Teacher extends CModel
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
     * @return array Associated students
     */
    protected $studentRelations;

    public function __construct()
    {
        $this->studentRelations = new DArrayCollection();
    }

    public function attributeNames()
    {
        return array(
            'id'    => 'id',
            'name'  => 'name',
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'    => 'id',
            'name'  => 'Имя преподавателя',
        );
    }

    public function addStudentRelation(ModelRelation $relation)
    {
        $this->studentRelations[] = $relation;
        return $this;
    }

    public function removeStudentRelation(ModelRelation $relation)
    {
        $this->studentRelations->removeElement($relation);
    }

    public function getStudentRelations()
    {
        return $this->studentRelations;
    }
}