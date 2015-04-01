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
    public function actionTeacherList($page = 1)
    {
        $perPage = 5;
        $teachersRepo = $this->getEntityManager()->getRepository('Teacher');
        $teachersRepo->setPerPage($perPage);
        $teachers = $teachersRepo->getAll($page);

        $dataProvider = new CustomDataProvider($teachers['data'], array(
            'id' => 'teacher-table',
            'pagination' => array(
                'pageSize' => 5,
            ),
        ));

        $pages = new CPagination($teachers['itemCount']);
        $pages->setPageSize(5);

        $dataProvider->setTotalItemCount($teachers['itemCount']);

        $this->render('teacherList', array(
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));
    }
}