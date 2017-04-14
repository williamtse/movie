<?php
namespace backend\modules\adminb\models;

use Yii;
use yii\base\Model;
use common\models\Admin;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $password;
    private $_user;
    private $_password_reset_token;

    public function getPasswordResetToen(){
        return $this->_password_reset_token;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'trim'],
            ['password', 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
            $user->generatePasswordResetToken();

            if (!$user->save()) {
                return false;
            }
            $this->_password_reset_token = $user->password_reset_token;
        }
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Admin::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
    }
}
