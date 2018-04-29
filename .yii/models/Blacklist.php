<?php

namespace app\models;

use app\components\Helper;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

class Blacklist extends ActiveRecord {
	const TYPE_ORG = 1;
	const TYPE_PERSON = 0;
	
	public static $filters = [
		self::TYPE_PERSON => 'физ. лица',
		self::TYPE_ORG => 'юр. лица',
	];
	
	/**
	 * @inheritdoc
	 */
	public function rules(){
		return [
//			[['text', 'comment'], 'required', 'message'=>'{attribute} – обязательное поле'],
			[['type'], 'number'],
			[['active'], 'boolean'],
			[['last_name', 'first_name', 'middle_name', 'birthdate', 'birthDate',
				'passport_series', 'passport_number', 'passport_organ', 'passport_date', 'passportNumber', 'passportDate',
				'phone', 'city', 'street', 'house', 'flat',
				'opf', 'org', 'inn', 'ogrn',
				'created_org', 'created_city', 'created_phone',
				'comment'], 'string']
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels(){
//		return [
//			'active' => 'Выводить текст на сайте',
//			'comment' => 'Комментарий к тексту (виден только администратору)',
//			'text' => 'Текст',
//		];
	}
	
	public function getBirthDate(){
		if($this->birthdate) return preg_replace('%^(\d{4})-(\d\d)-(\d\d)%ims', '$3.$2.$1', $this->birthdate);
		else return '';
	}
	
	public function setBirthDate($value){
		$value = trim($value);
		if(preg_match('%^(\d\d)\.(\d\d)\.(\d{4})$%ims', $value, $m)) $this->birthdate = $m[3].'-'.$m[2].'-'.$m[1];
		else if(preg_match('%^(\d{4})-(\d\d)-(\d\d)$%ims', $value)) $this->birthdate = $value;
		else $this->birthdate = null;
	}
	
	public function getPassportDate(){
		if($this->passport_date) return preg_replace('%^(\d{4})-(\d\d)-(\d\d)%ims', '$3.$2.$1', $this->passport_date);
		else return '';
	}
	
	public function setPassportDate($value){
		$value = trim($value);
		if(preg_match('%^(\d\d)\.(\d\d)\.(\d{4})%ims', $value, $m)) $this->passport_date = $m[3].'-'.$m[2].'-'.$m[1];
		else if(preg_match('%^(\d{4})-(\d\d)-(\d\d)$%ims', $value)) $this->passport_date = $value;
		else $this->passport_date = null;
	}

	public function getPassportNumber(){
		if($this->passport_series && $this->passport_number) return $this->passport_series. ' ' . $this->passport_number;
		else return '';
	}
	
	public function setPassportNumber($value){
		if(preg_match('%^(\d+)\s+(\d+)$%ims', trim($value), $m)) {
			$this->passport_series = $m[1];
			$this->passport_number = $m[2];
		} else {
			$this->passport_series = '';
			$this->passport_number = '';
		}
	}
}
