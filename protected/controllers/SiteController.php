<?php

class SiteController extends YDController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    /**
     * Создание нового учителя или ученика
     */
    public function actionCreatePerson()
    {
        $model = new CreatePersonForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'create-person-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['CreatePersonForm'])) {
            $model->attributes = $_POST['CreatePersonForm'];
            if ($model->validate()) {
                $person = $_POST['CreatePersonForm'];
                if ($person['isTeacher']) {
                    $personModel = new Teacher();
                } else {
                    $personModel = new Student();
                }
                $personModel->setName($person['name']);
                $em = $this->getEntityManager();
                $em->persist($personModel);
                $em->flush();
                $this->redirect(array('/site/createPerson'));
            }
        }
        $this->render('createPerson', array('model' => $model));
    }

    /**
     * Список учителей
     */
    public function actionTeacherList()
    {
        $dataProvider =  new CActiveDataProvider(Teacher::model(), array(
            'sort' => array(
                'defaultOrder' => array('id asc'),
//                'attributes'   => array(
//                    'id' => array(
//                        'asc' => 'id asc',
//                        'desc' => 'id desc',
//                    ),
//                    'name' => array(
//                        'asc' => 'name asc',
//                        'desc' => 'name desc',
//                    ),
//                    'studentCount'=> array(
//                        'asc'   =>'(SELECT COUNT(id) FROM sky_relation WHERE teacherId = t.id)',
//                        'desc'  =>'(SELECT COUNT(id) FROM sky_relation WHERE teacherId = t.id) DESC',
//                        'default'=>'desc',
//                    ),
//                ),

            )
        ));

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('teacherTable', array(
                'dataProvider' => $dataProvider,
            ));
        }
        $this->render('teacherList', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionTest()
    {
        $teachers = $this->getEntityManager()->getRepository('Teacher')->getAll();
        echo("<pre>");
        echo ("====================<br/>");
        foreach ($teachers as $t) {
            echo($t->getName() . "<br/>");
            echo("~~~~~~~~~~~~~~~~~~~~~~~~~~~<br/>");
            foreach ($t->getStudents() as $student) {
                echo("---" . $student->getName() . "<br/>");
            }
            echo("~~~~~~~~~~~~~~~~~~~~~~~~~~~<br/>");
        }

        $students = $this->getEntityManager()->getRepository('Student')->getAll();
        echo("<pre>");
        echo ("====================<br/>");
        foreach ($students as $s) {
            echo($s->getName() . "<br/>");
            echo("~~~~~~~~~~~~~~~~~~~~~~~~~~~<br/>");
            foreach ($s->getTeachers() as $teacher) {
                echo("---" . $teacher->getName() . "<br/>");
            }
            echo("~~~~~~~~~~~~~~~~~~~~~~~~~~~<br/>");
        }
    }
}