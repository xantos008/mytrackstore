<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $regip;
    public $lastip;
    public $checkmailcode;
    public $confirmemail;
    public $created_at_shifr;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
			
			['regip', 'string', 'max' => 255],
			['lastip', 'string', 'max' => 255],
			
            ['checkmailcode', 'string'],
            ['confirmemail', 'string'],
            ['created_at_shifr', 'string'],
		];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
		$user->regip = $this->regip;
		$user->lastip = $this->lastip;
		$user->checkmailcode = $this->checkmailcode;
        $user->confirmemail = $this->confirmemail;
        $user->created_at_shifr = $this->created_at_shifr;
        
        return $user->save() ? $user : null;
    }
}
