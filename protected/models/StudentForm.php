<?php

/**
 * Форма редактирования студента
 */
class StudentForm extends CFormModel
{
    public $name;

    public function rules()
    {
        return array(
            array('name', 'required'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'name'          => 'Имя студента',
        );
    }
}
