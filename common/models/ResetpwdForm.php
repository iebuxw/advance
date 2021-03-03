<?php
namespace common\models;

use common\models\Adminuser;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $password;
    public $password2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入密码不一致'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password2' => '重输密码',
        ];
    }

    /**
     * 修改密码
     * @return \common\models\Adminuser|null
     */
    public function reset($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = Adminuser::findOne($id);
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save() ? $user : null/* && $this->sendEmail($user)*/;
    }
}
