<?php

namespace app\controllers;

use app\models\Text;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\UploadedFile;

class TextsController extends Controller {
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
		if(!User::isAdmin()) return $this->redirect(['site/index'], 302);
		return parent::beforeAction($action);
	}
	
	/**
	 * Список текстов
	 *
	 * @return string
	 */
	public function actionIndex(){
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		
		$filter = [
			'status' => Text::FILTER_STATUS_ACTIVE,
			'search' => ''
		];
		if($session->has($this->id.'_filter')) $filter = array_merge($filter, $session[$this->id.'_filter']);
		if($filter1 = $request->get("filter")) $filter = array_merge($filter, $filter1);
		
		$query = Text::find(); //->where(['deleted' => 0]);
		if($filter['search']){
			$query
				->orWhere(['like', 'text', $filter['search']])
				->orWhere(['like', 'comment', $filter['search']])
			;
		}
		if($filter['status']!=Text::FILTER_STATUS_ALL){
			$query->andWhere(['active' => ($filter['status']==Text::FILTER_STATUS_ACTIVE ? Text::STATUS_ACTIVE : Text::STATUS_INACTIVE)]);
		}
		
		$countQuery = clone $query;
		$pages = new Pagination([
			'totalCount' => $countQuery->count(),
			'pageSize' => 100,
			'page' => $request->get('page', 1)-1
		]);
		$pages->params['filter'] = $filter;
		$session[$this->id.'_filter'] = $filter;
		
		$rows = $query
			->offset($pages->offset)
			->limit($pages->limit)
			->orderBy([
				'id' => SORT_ASC
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
			if(!($text = Text::findOne($id))){
				$session->addFlash("error", "Неверный ID текста");
				return $this->redirect(['texts/index'], 302);
			}
		} else {
			$text = new Text();
		}
		
		if($request->isPost){
			$sub_error = '';
			if($text->load($request->post()) && $text->save()){
				$session->addFlash("success", "Сохранено");
				return $this->redirect(['texts/index'], 302);
			}
			$session->addFlash("error", "Ошибка сохранения".$sub_error);
		}
		return $this->render('edit', [
			'model' => $text
		]);
	}
	
	/**
	 * @param $id
	 * @return Response
	 */
	public function actionDelete($id){
		$session = Yii::$app->session;

		if(!$id || !($text = Text::findOne($id))){
			$session->addFlash("error", "Неверный ID пользователя");
		} else {
			$text->active = Text::STATUS_INACTIVE;
			$text->save();
			$session->addFlash("success", "Текст скрыт с сайта");
		}
		return $this->redirect(['texts/index'], 302);
		
	}
	
	/**
	 * Публикация текста
	 *
	 * @param $id
	 * @return Response
	 */
	public function actionUndelete($id){
		$session = Yii::$app->session;
		
		if(!$id || !($text = Text::findOne($id))){
			$session->addFlash("error", "Неверный ID текста");
		} else {
			$text->active = Text::STATUS_ACTIVE;
			$text->save();
			$session->addFlash("success", "Текст опубликован");
		}
		return $this->redirect(['texts/index', 'filter' => ['status' => Text::FILTER_STATUS_ACTIVE]], 302);
	}
}
