<?php
/* @var $this SiteController */
/* @var $dataProvider CActiveDataProvider */
/* @var $model Teacher */
?>

<h2>Список учителей</h2>
<?php
$this->renderPartial('teacherTable', array('dataProvider' => $dataProvider));
