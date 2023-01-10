<?php

use yii\db\Migration;

/**
 * Class m221226_023421_init_rbac
 */
class m221226_023421_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        
        // add "managrAttendanceRecord" permission
        $manageAttendanceRecord = $auth->createPermission('manageAttendanceRecords');
        $manageAttendanceRecord->description = 'Manage attendance records';
        $auth->add($manageAttendanceRecord);

        // add "createAttendanceRecord" permission
        $createAttendanceRecord = $auth->createPermission('createAttendanceRecord');
        $createAttendanceRecord->description = 'Create an attendance record';
        $auth->add($createAttendanceRecord);

        // add "readAttendanceRecord" permission
        $viewAttendanceRecord = $auth->createPermission('viewAttendanceRecord');
        $viewAttendanceRecord->description = 'View an attendance record';
        $auth->add($viewAttendanceRecord);

        // add "updateAttendanceRecord" permission
        $updateAttendanceRecord = $auth->createPermission('updateAttendanceRecord');
        $updateAttendanceRecord->description = 'Update an attendance record';
        $auth->add($updateAttendanceRecord);

        // add "deleteAttendanceRecord" permission
        $deleteAttendanceRecord = $auth->createPermission('deleteAttendanceRecord');
        $deleteAttendanceRecord->description = 'Delete an attendance record';
        $auth->add($deleteAttendanceRecord);

        // add "manager" role and give this role the "createPost" permission
        $staff = $auth->createRole('staff');
        $auth->add($staff);
        $auth->addChild($staff, $createAttendanceRecord);
        $auth->addChild($staff, $viewAttendanceRecord);
        $auth->addChild($staff, $updateAttendanceRecord);

        $groupManager = $auth->createRole('groupManager');
        $auth->add($groupManager);
        $auth->addChild($groupManager, $manageAttendanceRecord);
        $auth->addChild($groupManager, $deleteAttendanceRecord);
        $auth->addChild($groupManager, $staff);
        
        $departmentManager = $auth->createRole('departmentManager');
        $auth->add($departmentManager);
        $auth->addChild($departmentManager, $groupManager);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $departmentManager);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($staff, 4);
        $auth->assign($groupManager,3);
        $auth->assign($departmentManager,2);
        //$auth->assign($,3);
        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221226_023421_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221226_023421_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
