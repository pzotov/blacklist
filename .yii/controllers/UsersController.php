<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\UploadedFile;

class UsersController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors(){
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	
	/**
	 * Сначала проверяем роль пользователя
	 *
	 * @param $action
	 * @return bool|Response
	 * @throws \yii\web\BadRequestHttpException
	 */
	public function beforeAction($action){
		if(!User::isAdmin() && $action->id!="profile") return $this->redirect(['site/index'], 302);
		return parent::beforeAction($action);
	}
	
	/**
	 * Список пользователей
	 *
	 * @return string
	 */
	public function actionIndex(){
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		
		$filter = [
			'status' => User::FILTER_STATUS_ACTIVE,
			'search' => ''
		];
		if($session->has($this->id.'_filter')) $filter = array_merge($filter, $session[$this->id.'_filter']);
		if($filter1 = $request->get("filter")) $filter = array_merge($filter, $filter1);
		
		$query = User::find(); //->where(['deleted' => 0]);
		if($filter['search']){
			$query
				->orWhere(['like', 'name', $filter['search']])
				->orWhere(['like', 'email', $filter['search']])
				->orWhere(['like', 'comment', $filter['search']])
			;
		}
		if($filter['status']!=User::FILTER_STATUS_ALL){
			$query->andWhere(['active' => ($filter['status']==User::FILTER_STATUS_ACTIVE ? User::STATUS_ACTIVE : User::STATUS_INACTIVE)]);
		}
		
		$countQuery = clone $query;
		$pages = new Pagination([
			'totalCount' => $countQuery->count(),
			'pageSize' => 10,
			'page' => $request->get('page', 1)-1
		]);
		$pages->params['filter'] = $filter;
		$session[$this->id.'_filter'] = $filter;
		
		$rows = $query
			->offset($pages->offset)
			->limit($pages->limit)
			->orderBy([
				'role' => SORT_DESC,
				'email' => SORT_ASC
			])
			->all();
		
		return $this->render('index', [
			'rows' => $rows,
			'filter' => $filter,
			'pages' => $pages
		]);
	}
	
	/**
	 * Добавление/изменения пользователя
	 *
	 * @return string
	 */
	public function actionEdit($id = 0){
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($id){
			if(!($user = User::findOne($id))){
				$session->addFlash("error", "Неверный ID пользователя");
				return $this->redirect(['users/index'], 302);
			}
		} else {
			$user = new User();
			$user->role = User::USER_CLIENT;
			$user->active = true;
		}
		
		if($request->isPost){
			$sub_error = '';
			if($user->load($request->post())){
				if(!$id){
					$user->setNewPassword($request->post('User')['password']);
				} else if($new_password = $request->post('User')['new_password']){
					$user->setNewPassword($new_password);
				}
				if(User::find()
					->where(['email' => $user->email])
					->andWhere(['<>', 'id', $id])
					->count()
				){
					$sub_error .= "<br>Пользователь с e-mail {$user->email} уже существует";
				} else if($user->save()){
					if(!$id){
						//Создали нового пользователя, поэтому нужно отправить ему письмо
						$message = Yii::$app->mailer
							->compose('user_register', [
								'user' => $user,
								'password' => $request->post('User')['password']
							])
							->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['siteName']])
							->setReplyTo([Yii::$app->params['adminEmail'] => Yii::$app->params['siteName']])
							->setTo($user->email)
							->setSubject("Регистрация на сайте ".Yii::$app->params['siteName'])
						;
						$message->send();
						
					}
					
					$session->addFlash("success", "Сохранено");
					return $this->redirect(['users/index'], 302);
				}
				$user->password = '';
			}
			$session->addFlash("error", "Ошибка сохранения".$sub_error);
		}
		return $this->render('edit', [
			'model' => $user
		]);
	}
	
	/**
	 * @param $id
	 * @return Response
	 */
	public function actionDelete($id){
		$session = Yii::$app->session;

		if(!$id || !($user = User::findOne($id))){
			$session->addFlash("error", "Неверный ID пользователя");
		} else {
			$user->active = false;
			$user->save();
			$session->addFlash("success", "Пользователь отключен");
		}
		return $this->redirect(['users/index'], 302);
		
	}
	
	/**
	 * Восстанавливает пользователя из удаленных
	 *
	 * @param $id
	 * @return Response
	 */
	public function actionUndelete($id){
		$session = Yii::$app->session;
		
		if(!$id || !($user = User::findOne($id))){
			$session->addFlash("error", "Неверный ID пользователя");
		} else {
			$user->active = true;
			$user->save();
			$session->addFlash("success", "Пользователь восстановлен");
		}
		return $this->redirect(['users/index', 'filter' => ['status' => User::FILTER_STATUS_ACTIVE]], 302);
	}
}
