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
     * @return array Associated teachers
     */
    protected $teachers;

    public function __construct()
    {
        parent::__construct();
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
}