<?php

namespace app\models;

use app\components\Helper;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class User extends ActiveRecord implements \yii\web\IdentityInterface {
	const USER_CLIENT = 0; //Простой пользователь
	const USER_ADMIN = 1; //Администратор
	
	protected static $roles = [
		self::USER_CLIENT => 'Клиент',
		self::USER_ADMIN => 'Админ',
	];
	
	public $new_password;
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	protected static $statuses = [
		self::STATUS_ACTIVE => 'активен',
		self::STATUS_INACTIVE => 'отключен',
	];

	const FILTER_STATUS_ALL = -1;
	const FILTER_STATUS_ACTIVE = 1;
	const FILTER_STATUS_INACTIVE = 2;
	public static $filters = [
		self::FILTER_STATUS_ALL => 'все',
		self::FILTER_STATUS_ACTIVE => 'активные',
		self::FILTER_STATUS_INACTIVE => 'отключенные',
	];
	
	/**
	 * @inheritdoc
	 */
	public function behaviors(){
		return [
			[
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
					ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
				],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function rules(){
		return [
			[['email', 'name'], 'required', 'message'=>'{attribute} – обязательное поле'],
			[['role', 'active_till'], 'number'],
			[['active'], 'boolean'],
			[['new_password', 'phone', 'password', 'comment', 'activeTill'], 'string']
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels(){
		return [
			'email' => 'E-mail (он же логин)',
			'name' => 'ФИО пользователя',
			'phone' => 'Телефон',
			'password' => 'Пароль',
			'new_password' => 'Новый пароль (если нужно сменить)',
			'active' => 'Доступ разрешен',
			'activeTill' => 'До какой даты разрешен доступ к сайту (если нужно ограничение)',
			'role' => 'Роль',
			'comment' => 'Комментарий',
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id){
		return self::findOne($id);
	}

	/**
	 * Finds user by username
	 *
	 * @param  string $username
	 * @return static|null
	 */
	public static function findByUsername($username){
		$user = self::find()
			->where('email=:email AND active=:active AND (active_till=0 OR active_till>:time)')
			->addParams([
				':email' => $username,
				':active' => self::STATUS_ACTIVE,
				':time' => time()
			])
			->one()
		;
		return $user;
	}
	
	/**
	 * @inheritdoc
	 */
	public function getId(){
		return $this->id;
	}
	
	public function getNewPassword(){
		return '';
	}
	
	public function setNewPassword($password){
		if($password) $this->password = md5($password);
	}
	
	/**
	 * Validates password
	 *
	 * @param  string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password){
		return $this->password === md5($password);
	}
	
	/**
	 * @inheritdoc
	 */
	public function getAuthKey(){
		return null;
		return $this->authKey;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey){
		return false;
		return $this->authKey === $authKey;
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null){
		return null;
		foreach (self::$users as $user){
			if($user['accessToken'] === $token){
				return new static($user);
			}
		}

		return null;
	}

	public static function isAdmin(){
		return \Yii::$app->user->identity->role == self::USER_ADMIN;
	}
	
	public function getRoleText(){
		return self::$roles[$this->role];
	}

	public function getStatus(){
		$result = self::$statuses[$this->active];
		if($this->active && $this->active_till) $result .= ' до&nbsp;'.$this->activeTill;
		return $result;
	}

	public static function getRoleList(){
		return self::$roles;
	}
	
	/**
	 * Список всех пользователей, сгруппированных по ролям
	 * @return array
	 */
	public static function getAllUsersList(){
		$list = [];
		foreach(self::$roles as $role_id => $role_name){
			$list[$role_name] = ArrayHelper::map(self::find()
				->select(['id', 'name'])
				->where(['deleted' => 0])
				->andWhere(['role' => $role_id])
				->orderBy(['name' => SORT_ASC])
				->all(), 'id', 'name');
		}
		return $list;
	}
	
	public function getActiveTill(){
		return $this->active_till ? @date('d.m.Y', $this->active_till) : '';
	}
	
	public function setActiveTill($value){
		$value = trim($value);
		$this->active_till = $value ? strtotime($value.' 23:59:59') : 0;
	}
}
