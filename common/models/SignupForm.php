<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;
    public $nickname;
    public $profile;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '用户名已存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '邮箱已存在'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入密码不一致'],
            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 128],
            ['profile', 'string', 'max' => 2550],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'password2' => '重输密码',
            'email' => '邮箱',
            'profile' => '简介',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
        ];
    }

    /**
     * Signs user up.
     * @return \common\models\Adminuser|null
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Adminuser();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->nickname = $this->nickname;
        $user->profile = $this->profile;
        $user->password = '*';
        $user->setPassword($this->password);
        $user->generateAuthKey();
//        $user->generateEmailVerificationToken();
//        $user->save();
//        dd($user->errors);
        return $user->save() ? $user : null/* && $this->sendEmail($user)*/;
    }

    /**
     * Sends confirmation email to user
     * @param Adminuser $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
