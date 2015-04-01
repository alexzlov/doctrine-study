<?php
/* @var $this SiteController */
/* @var $studentsNotAssigned array */
/* @var $teacher Teacher */
/* @var $studentsAssigned CActiveDataProvider */

/**
 * Отрисовка формы с возможностью выбора студентов
 * для ее последующей отправки через AJAX
 */

?>
<h3>Преподаватель: <kbd>
        <?php echo $teacher->name; ?>
    </kbd></h3>

<p>Выберите студента из списка, чтобы закрепить его за преподавателем: </p>
<?php
echo CHtml::beginForm('/site/saveStudents/' . $teacher->id, 'post', ['id' => 'student-selector']);
$this->widget(
    'booster.widgets.TbSelect2',
    array(
        'name' => 'students-list',
        'data' => $studentsNotAssigned,
        'htmlOptions' => array(
            'multiple' => 'multiple',
        ),
    )
);
$this->widget('yiibooster.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label'      => 'Назначить',
));
echo CHtml::endForm();

echo('<hr/>');
?>

<h4>Студенты, закрепленные за преподавателем:</h4>
<?php
$this->widget(
    'booster.widgets.TbGridView',
    array(
        'id'            => 'student-table',
        'type'          => 'striped',
        'dataProvider'  => $studentsAssigned,
        'template'      => "{items}"
    )
);