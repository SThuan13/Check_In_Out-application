<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        
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

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        $auth->addChild($manager, $manageAttendanceRecord);
        $auth->addChild($manager, $deleteAttendanceRecord);
        $auth->addChild($manager, $staff);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        //$auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $manager);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($staff, 3);
        $auth->assign($manager, 2);
        $auth->assign($admin, 1);
    }
}