<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
    <div id="mainmenu">
        <?php
        $this->widget(
            'yiibooster.widgets.TbNavbar',
            array(
                'brand' => CHtml::encode(Yii::app()->name),
                'fixed' => false,
                'fluid' => true,
                'items' => array(
                    array(
                        'class' => 'yiibooster.widgets.TbMenu',
                        'type' => 'navbar',
                        'items' => array(
                            array('label' => 'Создать учителя/ученика', 'url' => array('/site/createPerson')),
                            array('label' => 'Список учителей', 'url' => array('/site/teacherList')),
                            array('label' => 'Список студентов', 'url' => array('/site/studentList')),
                        )
                    )
                )
            )
        );
        ?>
    </div><!-- mainmenu -->

    <?php
    $this->widget(
        'yiibooster.widgets.TbBreadcrumbs',
        array(
            'links' => $this->breadcrumbs,
        )
    );
    ?>
    <div class="content">
        <?php echo $content; ?>
    </div>

    <div class="clear"></div>

</div><!-- page -->

</body>
</html>
