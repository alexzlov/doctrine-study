<?php
/* @var $this YDController */
/* @var $model StudentForm */
/* @var $form TbActiveForm  */

$this->pageTitle='Редактирование студента';
$this->breadcrumbs=array(
    'Редактирование студента',
);
?>

<h1>Вход</h1>

<div class="form">

    <?php
    $form = $this->beginWidget('yiibooster.widgets.TbActiveForm', array(
        'id' => 'student-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'well',
        ),
    ));
    ?>
    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны для заполнения.</p>
    <?php
    echo $form->textFieldGroup($model, 'name');

    $this->widget('yiibooster.widgets.TbButton', array(
        'buttonType' => 'submit', 'label' => 'Сохранить'
    ));
    $this->endWidget();
    unset($form);
    ?>
</div><!-- form -->
