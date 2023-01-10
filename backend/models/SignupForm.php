<?php

namespace app\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Tên tài khoản',
            'password' => 'Mật khẩu',
            'status' => 'Trạng thái',
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
