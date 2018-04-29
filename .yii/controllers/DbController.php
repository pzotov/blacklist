<?php

namespace app\controllers;

use app\models\Blacklist;
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

class DbController extends Controller {
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
	
	
	public function actionIndex(){
		$session = Yii::$app->session;
		$request = Yii::$app->request;
		
		$filter = [
			'type' => Blacklist::TYPE_PERSON,
			'search' => ''
		];
		if($session->has($this->id.'_filter')) $filter = array_merge($filter, $session[$this->id.'_filter']);
		if($filter1 = $request->get("filter")) $filter = array_merge($filter, $filter1);
		
		$query = Blacklist::find();
		if($filter['search']){
			$query
				->orWhere(['like', 'last_name', $filter['search']])
				->orWhere(['like', 'first_name', $filter['search']])
				->orWhere(['like', 'middle_name', $filter['search']])
				->orWhere(['like', 'opf', $filter['search']])
				->orWhere(['like', 'org', $filter['search']])
				->orWhere(['like', 'phone', $filter['search']])
				->orWhere(['like', 'city', $filter['search']])
				->orWhere(['like', 'created_city', $filter['search']])
				->orWhere(['like', 'created_org', $filter['search']])
				->orWhere(['like', 'comment', $filter['search']])
			;
		}
		$query->andWhere(['type' => $filter['type']]);
		
		$countQuery = clone $query;
		$pages = new Pagination([
			'totalCount' => $countQuery->count(),
			'pageSize' => 10,
			'page' => $request->get('page', 1)-1
		]);
		$pages->params['filter'] = $filter;
		$session[$this->id.'_filter'] = $filter;
		
		$orderBy = ['active' => SORT_ASC];
		if($filter['type']==Blacklist::TYPE_PERSON){
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
		
		return $this->render('index', [
			'rows' => $rows,
			'filter' => $filter,
			'pages' => $pages
		]);
	}
	
	/**
	 * Добавление/изменения записи в бд
	 *
	 * @return string
	 */
	public function actionEdit($id = 0){
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($id){
			if(!($model = Blacklist::findOne($id))){
				$session->addFlash("error", "Неверный ID записи");
				return $this->redirect(['db/index'], 302);
			}
		} else {
			$model = new Blacklist();
			$model->active = true;
			$model->type = $request->get("type");
		}
		
		if($request->isPost){
			$sub_error = '';
			if($model->load($request->post()) && $model->save()){
				$session->addFlash("success", "Запись успешно добавлена");
				return $this->redirect(['db/index'], 302);
			}
			$session->addFlash("error", "Ошибка сохранения".$sub_error);
		}
		return $this->render('edit', [
			'model' => $model
		]);
	}
	
	/**
	 * @param $id
	 * @return Response
	 */
	public function actionDeactivate($id){
		$session = Yii::$app->session;
		
		if(!$id || !($model = Blacklist::findOne($id))){
			$session->addFlash("error", "Неверный ID записи");
		} else {
			$model->active = false;
			$model->save();
			$session->addFlash("success", "Запись снята с публикации");
		}
		return $this->redirect(['db/index'], 302);
		
	}
	
	/**
	 * Публикуем запись
	 *
	 * @param $id
	 * @return Response
	 */
	public function actionActivate($id){
		$session = Yii::$app->session;
		
		if(!$id || !($model = Blacklist::findOne($id))){
			$session->addFlash("error", "Неверный ID записи");
		} else {
			$model->active = true;
			$model->save();
			$session->addFlash("success", "Запись опубликована");
		}
		return $this->redirect(['db/index'], 302);
	}
	
	/**
	 * Удаляем запись
	 *
	 * @param $id
	 * @return Response
	 */
	public function actionDelete($id){
		$session = Yii::$app->session;
		
		if(!$id || !($model = Blacklist::findOne($id))){
			$session->addFlash("error", "Неверный ID записи");
		} else {
			$model->delete();
			$session->addFlash("info", "Запись удалена");
		}
		return $this->redirect(['db/index'], 302);
	}
	
	/**
	 * Загрузка базы данных
	 *
	 * @return string
	 */
	public function actionUpload(){
		$request = Yii::$app->request;
		$session = Yii::$app->session;
		
		if($request->isPost){
			$sub_error = '';
			
			if($_FILES['file'] && !$_FILES['file']['error']){
				try {
					$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($_FILES['file']['tmp_name']);
					$reader->setReadDataOnly(true);
					$ea = $reader->load($_FILES['file']['tmp_name']);
					
//					Blacklist::deleteAll(['active' => 1]);
					
					//Лист с физлицами
					$ews = $ea->getSheet(0);
					$max_row = $ews->getHighestRow();
					$max_col = $ews->getHighestColumn();
					
//					echo '<pre>';
					
					for ($row = 4; $row <= $max_row; $row++){
						$_data = $ews->rangeToArray('a'.$row.':'.$max_col.$row, NULL, true, false);
						$data = $_data[0];
						$row_ok = false;
						foreach($data as $k => $v){
							$v = trim($v);
							$data[$k] = $v;
							if(strlen($v)) $row_ok = true;
						}
						if(!$row_ok) continue;
						
						$item = new Blacklist();
						$item->type = Blacklist::TYPE_PERSON;
						$item->last_name = $data[1];
						$item->first_name = $data[2];
						$item->middle_name = $data[3];
						$item->birthDate = $data[4];
						$item->passport_series = $data[5];
						$item->passport_number = $data[6];
						$item->passport_organ = $data[7];
						$item->passportDate = $data[8];
						$item->phone = $data[9];
						$item->city = $data[10];
						$item->street = $data[11];
						$item->house = $data[12];
						$item->flat = $data[13];
						$item->created_org = $data[14];
						$item->created_city = $data[15];
						$item->created_phone = $data[16];
						$item->comment = $data[17];

						$item->save();
					}
					
					//Лист с юрлицами
					$ews = $ea->getSheet(1);
					$max_row = $ews->getHighestRow();
					$max_col = $ews->getHighestColumn();
					
					for ($row = 4; $row <= $max_row; $row++){
						$_data = $ews->rangeToArray('a'.$row.':'.$max_col.$row, NULL, true, false);
						$data = $_data[0];
						$row_ok = false;
						foreach($data as $k => $v){
							$v = trim($v);
							$data[$k] = $v;
							if(strlen($v)) $row_ok = true;
						}
						if(!$row_ok) continue;
						
						$item = new Blacklist();
						$item->type = Blacklist::TYPE_ORG;
						$item->opf = $data[1];
						$item->org = $data[2];
						$item->inn = $data[3];
						$item->ogrn = $data[4];
						$item->phone = $data[5];
						$item->city = $data[6];
						$item->street = $data[7];
						$item->house = $data[8];
						$item->flat = $data[9];
						$item->created_org = $data[10];
						$item->created_city = $data[11];
						$item->created_phone = $data[12];
						$item->comment = $data[13];
						
						$item->save();
					}
				} catch(\Exception $e){
					$session->addFlash("error",
						$e->getMessage().' file: '.$e->getFile().' @ '.$e->getLine().'<br><br>'.$e->getTraceAsString());
					return $this->redirect(['db/upload'], 302);
				}
				
				$session->addFlash("success", "Файл успешно загружен");
				return $this->redirect(['db/upload'], 302);
			}
			$session->addFlash("error", "Ошибка обработки".$sub_error);
		}
		return $this->render('upload');
	}
	
	/**
	 * Экспорт базы данных в xlsx
	 *
	 * @return string
	 */
	public function actionDownload(){
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle(Blacklist::$filters[Blacklist::TYPE_PERSON]);
		
		$sheet = $spreadsheet->createSheet();
		$sheet->setTitle(Blacklist::$filters[Blacklist::TYPE_ORG]);
		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$tmp_file = Yii::getAlias('@app/runtime/cache/db.xlsx');
		$writer->save($tmp_file);
		
		ob_end_clean();
		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-disposition: attachement; filename="'.Html::encode(basename($tmp_file)).'"');
		@readfile($tmp_file);
		
		@unlink($tmp_file);
	}
}
