<?php

namespace app\controllers;

use app\models\Blacklist;
use app\models\Text;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

class SearchController extends Controller {
	/**
	 * {@inheritdoc}
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
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		$model = new Blacklist();
		$model->type = Blacklist::TYPE_PERSON;
		
		$filter = [];
		
		if($request->isPost){
			if($model->load($request->post())){
//				echo '<pre>';
//				var_dump($request->post());
//				var_dump($model);exit;
				$filter['type'] = $model->type;
				if($model->type==Blacklist::TYPE_PERSON){
					//поиск физлиц
					if(trim($model->last_name)) $filter['last_name'] = trim($model->last_name);
					if(trim($model->first_name)) $filter['first_name'] = trim($model->first_name);
					if(trim($model->middle_name)) $filter['middle_name'] = trim($model->middle_name);
					if($model->birthdate) $filter['birthdate'] = $model->birthdate;
					if($model->passport_series) $filter['passport_series'] = $model->passport_series;
					if($model->passport_number) $filter['passport_number'] = $model->passport_number;
					if($model->passport_organ) $filter['passport_organ'] = $model->passport_organ;
					if($model->passport_date) $filter['passport_date'] = $model->passport_date;
				} else {
					//поиск юрлиц
					if(trim($model->opf)) $filter['opf'] = trim($model->opf);
					if(trim($model->org)) $filter['org'] = trim($model->org);
					if(trim($model->inn)) $filter['inn'] = trim($model->inn);
					if(trim($model->ogrn)) $filter['ogrn'] = trim($model->ogrn);
				}
			}
		} else if($request->get('submit') && $session->has('search_params')){
			$filter = $session->get('search_params');
			foreach($filter as $key => $value){
				$model->$key = $value;
			}
		}
		
		if(count($filter)>1){
			$query = Blacklist::find()
				->where($filter)
				->andWhere(['active' => 1])
			;
			
			$countQuery = clone $query;
			$pages = new Pagination([
				'totalCount' => $countQuery->count(),
//				'pageSize' => 1,
				'page' => $request->get('page', 1)-1
			]);
			$pages->params['submit'] = true;
			$session['search_params'] = $filter;
			
			$orderBy = [];
			if($model->type==Blacklist::TYPE_PERSON){
				$orderBy['last_name'] = SORT_ASC;
				$orderBy['first_name'] = SORT_ASC;
				$orderBy['middle_name'] = SORT_ASC;
			} else {
				$orderBy['org'] = SORT_ASC;
				$orderBy['opf'] = SORT_ASC;
			}
			
			$rows = $query
				->offset($pages->offset)
				->limit($pages->limit)
				->orderBy($orderBy)
				->all();
		} else {
			$rows = [];
		}
		
		return $this->render('index', [
			'model' => $model,
			'rows' => $rows,
			'pages' => $pages,
			'submitted' => $request->isPost || $request->get('submit')
		]);
	}
	
	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionNew(){
		$request = Yii::$app->request;
		$session = Yii::$app->session;

		$model = new Blacklist();
		$model->type = Blacklist::TYPE_PERSON;
		$model->active = User::isAdmin() ? true : false;
		
		if($request->isPost){
			if($model->load($request->post()) && $model->save()){
				if(1||!User::isAdmin()){
					$admin_mails = ArrayHelper::map(User::find()
						->select(['email', 'name'])
						->where([
							'role' => User::USER_ADMIN,
							'active' => User::STATUS_ACTIVE
						])
						->all(), 'email', 'name');
					$message = Yii::$app->mailer
						->compose('new_item', [
							'model' => $model
						])
						->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['siteName']])
						->setTo($admin_mails)
						->setSubject("Новая запись в базу на сайте ".Yii::$app->params['siteName']);
					$message->send();
				}
				$session->addFlash("success", Text::get(6));
				return $this->redirect(['site/index'], 302);
			}
		}
		
		return $this->render('contact', [
			'model' => $model
		]);
	}
	
}
