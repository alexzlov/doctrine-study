<p>
    Для того, чтобы отредактировать данные студента, щелкните по соответствующей иконке справа.
</p>
<?php
/* @var $this SiteController */
/* @var $dataProvider CustomDataprovider */
/* @var $model Teacher */

/**
 * Список учителей с количеством связанных с ними студентов и
 * возможностью привязки к ним дополнительных студентов.
 */

$this->widget(
    'booster.widgets.TbGridView',
    array(
        'type' => 'striped',
        'dataProvider' => $dataProvider,
        'ajaxUpdate' => true,
        'template' => "{items}",
        'enablePagination' => true,
        'pager' => array(
            'class' => 'booster.widgets.TbPager',

        ),
        'columns' => array(
            array(
                'name'          => 'id',
                'header'        => '#',
                'value'         => '$data["id"]',
                'htmlOptions'   => array('style'=>'width: 60px')),
            array(
                'name'          => 'name',
                'header'        => 'Имя',
                'value'         => '$data["name"]',
            ),
            array(
                'htmlOptions'       => array('nowrap'=>'nowrap'),
                'class'             => 'TbIdButtonColumn',
                'template'          => '{assign_student}',
                'buttons'           => array(
                    'assign_student'    => array(
                        'label'             => '',
                        'url'               => 'Yii::app()->createUrl("/site/editStudent", array("id"=>$data["id"]))',
                        'options'           => array(
                            'class'             => 'glyphicon glyphicon-user',
                            'data-toggle'       => 'tooltip',
                            'title'             => 'Редактировать',
                            'id'                => '$data["id"]'
                        ),
                    )
                )
            )
        )
    )
);
$this->widget('booster.widgets.TbPager', array(
    'pages' => $pages,
));