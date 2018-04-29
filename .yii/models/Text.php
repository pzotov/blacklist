<?php

namespace app\models;

use app\components\Helper;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Text extends ActiveRecord {
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 0;
	
	protected static $statuses = [
		self::STATUS_ACTIVE => 'включен',
		self::STATUS_INACTIVE => 'скрыт',
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
			[['text', 'comment'], 'required', 'message'=>'{attribute} – обязательное поле'],
			[['active'], 'boolean'],
			[['text', 'comment'], 'string']
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels(){
		return [
			'active' => 'Выводить текст на сайте',
			'comment' => 'Комментарий к тексту (виден только администратору)',
			'text' => 'Текст',
		];
	}
	
	public static function get($id){
		if($text = self::find()
			->where(['id' => $id, 'active' => self::STATUS_ACTIVE])
			->one()) return $text->text;
		else return '';
	}
	
	public function getStatus(){
		$result = self::$statuses[$this->active];
		return $result;
	}
	
}
