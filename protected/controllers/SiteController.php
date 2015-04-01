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
     * @param integer $page
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
                'pageSize' => $perPage,
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

    /**
     * Список студентов
     * @param integer $page
     */
    public function actionStudentList($page = 1)
    {
        $perPage = 5;
        $studentRepo = $this->getEntityManager()->getRepository('Student');
        $studentRepo->setPerPage($perPage);
        $students = $studentRepo->getAll($page);

        $dataProvider = new CustomDataProvider($students['data'], array(
            'id' => 'teacher-table',
            'pagination' => array(
                'pageSize' => $perPage,
            ),
        ));

        $pages = new CPagination($students['itemCount']);
        $pages->setPageSize(5);

        $dataProvider->setTotalItemCount($students['itemCount']);

        $this->render('studentList', array(
            'dataProvider' => $dataProvider,
            'pages' => $pages,
        ));
    }

    /**
     * Находит студентов, НЕ назначенных выбранному учителю,
     * и рендерит в ajax соответствующую форму для их выбора
     * @param $id int id преподавателя
     */
    public function actionAssignStudent($id)
    {
        if (!$id) {
            echo("Такой преподаватель не найден :(");
            Yii::app()->end();
        }
        $teacher = $this->getEntityManager()->find('Teacher', $id);
        $studentsAssigned    = $this->getEntityManager()->getRepository('Teacher')->studentsAssigned($id);
        $SADataprovider = new CustomDataProvider($studentsAssigned);
        $SADataprovider->setTotalItemCount(count($studentsAssigned));
        $studentsNotAssigned = $this->getEntityManager()->getRepository('Teacher')->studentsNotAssigned($id);
        $out = array();
        foreach ($studentsNotAssigned as $student) {
            $out[$student['id']] = $student['name'];
        }
        $this->render('studentsToAssign', array(
            'studentsNotAssigned'   => $out,
            'studentsAssigned'      => $SADataprovider,
            'teacher'               => $teacher,
        ));
    }

    /**
     * Сохраняет закрепленных за преподавателем студентов
     * @param $id int id преподавателя
     */
    public function actionSaveStudents($id)
    {
        $redirectUrl = array('/site/teacherList');
        if (!array_key_exists('students-list', $_POST) || !$id) {
            $this->redirect($redirectUrl);
        }
        $studentIds = $_POST['students-list'];
        if (!count($studentIds)) {
            $this->redirect($redirectUrl);
        }

        $em = $this->getEntityManager();

        foreach ($studentIds as $studentId) {
            $rel = new ModelRelation();
            $rel->setTeacherId($id);
            $rel->setStudentId($studentId);
            $em->persist($rel);
        }
        $em->flush();
        $this->redirect($redirectUrl);
    }

    /**
     * Редактирование студента
     * @param integer $id
     */
    public function actionEditStudent($id)
    {
        $student = $this->getEntityManager()->find('Student', $id);

        $model = new StudentForm();
        $model->name = $student->getName();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'student-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['StudentForm'])) {
            $newName = $_POST['StudentForm']['name'];
            $em = $this->getEntityManager();

            $student = $em->find('Student', $id);
            $student->setName($newName);
            $em->flush();
            $this->redirect(array('/site/studentList'));
        }
        $this->render('editStudent', array('model' => $model));
    }
}