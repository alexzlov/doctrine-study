<?php

/**
 * Форма создания учителя/студента
 */
class CreatePersonForm extends CFormModel
{
    public $name;

    public $isTeacher;

    public function rules()
    {
        return array(
            array('name', 'required'),
            array('isTeacher', 'boolean'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Имя',
            'isTeacher' => 'Преподаватель',
        );
    }
}