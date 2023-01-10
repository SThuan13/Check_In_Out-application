<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $id;
    public $name;
    public $email;
    public $phoneNumber;
    public $user_id;
    public $department_id;
    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phoneNumber', 'user_id', 'department_id'], 'required'],
            [['user_id', 'department_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phoneNumber'], 'string', 'max' => 11],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],

            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();

        return $user->save();
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    // protected function sendEmail($user)
    // {
    //     return Yii::$app
    //         ->mailer
    //         ->compose(
    //             ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
    //             ['user' => $user]
    //         )
    //         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
    //         ->setTo($this->email)
    //         ->setSubject('Account registration at ' . Yii::$app->name)
    //         ->send();
    // }
}
