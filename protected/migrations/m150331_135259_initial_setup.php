<?php

class m150331_135259_initial_setup extends CDbMigration
{
	public function up()
	{
        $this->createTable('sky_teacher', array(
            'id'                => 'pk',
            'name'              => 'string NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        echo PHP_EOL . "Создана таблица учителей" . PHP_EOL;

        $this->createTable('sky_student', array(
            'id'                => 'pk',
            'name'              => 'string NOT NULL',
        ),  'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
        echo PHP_EOL . "Создана таблица учеников" . PHP_EOL;

        $this->createTable('sky_relation', array(
            'id'            => 'pk',
            'teacherId'     => 'int(11) NOT NULL',
            'studentId'     => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey(
            'fk_teacher_constraint',
            'sky_relation',
            'teacherId',
            'sky_teacher',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_student_constraint',
            'sky_relation',
            'studentId',
            'sky_student',
            'id',
            'RESTRICT',
            'CASCADE'
        );
        echo PHP_EOL . "Добавлены внешние ключи" . PHP_EOL;
	}

	public function down()
	{
		$this->dropForeignKey('fk_student_constraint', 'sky_relation');
        $this->dropForeignKey('fk_teacher_constraint', 'sky_relation');
        $this->dropTable('sky_relation');
        $this->dropTable('sky_student');
        $this->dropTable('sky_teacher');
        echo PHP_EOL . "Все данные удалены" . PHP_EOL;
	}
}