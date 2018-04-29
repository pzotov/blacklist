<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {
	/**
	 * {@inheritdoc}
	 */
	public function behaviors(){
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function actions(){
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex(){
		return $this->render('index');
	}
	
	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin(){
		$this->layout = "main0";
		if(!Yii::$app->user->isGuest){
			return $this->goHome();
		}
		
		$model = new LoginForm();
		if($model->load(Yii::$app->request->post()) && $model->login()){
			return $this->goBack();
		}
		
		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}
	
	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout(){
		Yii::$app->user->logout();
		
		return $this->goHome();
	}
	
	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionProfile(){
		$request = Yii::$app->request;
		$session = Yii::$app->session;

		$model = Yii::$app->user->identity;
		if($model->load($request->post())){
			$sub_error = '';
			$model->id = Yii::$app->user->identity->id;
			$model->role = Yii::$app->user->identity->role;
			$model->active = Yii::$app->user->identity->active;
			$model->active_till = Yii::$app->user->identity->active_till;
			if($new_password = $request->post('User')['new_password']){
				$model->setNewPassword($new_password);
			}
			if(User::find()
				->where(['email' => $model->email])
				->andWhere(['<>', 'id', $model->id])
				->count()){
				$sub_error .= "<br>Пользователь с e-mail {$model->email} уже существует";
			}
			if($model->save()){
				$session->addFlash("success", "Изменения сохранены");
				return $this->refresh();
			}
			$session->addFlash("error", "Ошибка сохранения".$sub_error);
		}
		return $this->render('profile', [
			'model' => $model,
		]);
	}
	
	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout(){
		return $this->render('about');
	}
}
