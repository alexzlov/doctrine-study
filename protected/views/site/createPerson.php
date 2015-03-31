<?php
/* @var $this SiteController    */
/* @var $model CreatePersonForm */
/* @var $form TbActiveForm      */
$this->breadcrumbs = array(
    'Новая запись',
);
?>

<h1>Создание новой записи</h1>

<div class="form">
    <?php
    $form = $this->beginWidget('yiibooster.widgets.TbActiveForm', array(
        'id' => 'create-person-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'class' => 'well',
        ),
    ));
    ?>
    <p class="note">Если Вы создаете преподавателя, отметьте соответствующий пункт.</p>
    <?php
    echo $form->textFieldGroup($model, 'name');
    echo $form->checkBoxGroup($model, 'isTeacher');

    $this->widget('yiibooster.widgets.TbButton', array(
        'buttonType' => 'submit', 'label' => 'Создать'
    ));
    $this->endWidget();
    unset($form);
    ?>
</div>