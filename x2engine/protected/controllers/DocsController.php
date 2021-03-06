<?php
/*********************************************************************************
 * X2Engine is a contact management program developed by
 * X2Engine, Inc. Copyright (C) 2011 X2Engine Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY X2Engine, X2Engine DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact X2Engine, Inc. at P.O. Box 66752,
 * Scotts Valley, CA 95067, USA. or at email address contact@X2Engine.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * X2Engine" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by X2Engine".
 ********************************************************************************/

class DocsController extends x2base {

	public $modelClass="DocChild";
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','exportToHtml','changePermissions'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->redirect(array('admin/viewPage/'.$id));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
			$users=UserChild::getNames();
			unset($users['Anyone']);
			unset($users['admin']);
			unset($users[Yii::app()->user->getName()]);
			$model=new DocChild;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DocChild']))
		{
			$model->attributes=$_POST['DocChild'];
			$model->text=$_POST['msgpost'];

			$arr=$model->editPermissions;
			if(isset($arr))
				$model->editPermissions=AccountChild::parseUsers($arr);

			$model->createdBy=Yii::app()->user->getName();
			$model->createDate=time();
			$model=$this->updateChangeLog($model,'Create');
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'users'=>$users,
		));
	}
	
	public function actionChangePermissions($id){
		$model=$this->loadModel($id);
		if(Yii::app()->user->getName()=='admin' || Yii::app()->user->getName()==$model->createdBy){
			$users=UserChild::getNames();
			unset($users['admin']);
			unset($users['Anyone']);
			$str=$model->editPermissions;
			$pieces=explode(", ",$str);
			$model->editPermissions=$pieces;
			
			if(isset($_POST['DocChild'])){
				$model->attributes=$_POST['DocChild'];
				$arr=$model->editPermissions;
				
				$model->editPermissions=AccountChild::parseUsers($arr);
				if($model->save()){
					$this->redirect(array('view','id'=>$id));
				}
			}
			
			$this->render('editPermissions',array(
				'model'=>$model,
				'users'=>$users,
			));
		}else{
			$this->redirect(array('view','id'=>$id));
		}
	}
        
    public function actionExportToHtml($id){
            
		$model=$this->loadModel($id);
		$file='doc.html';
		$fp=fopen($file,'w+');
		$data="<style>
				#wrap{
					width:6.5in;
					height:9in;
					margin-top:auto;
					margin-left:auto;
					margin-bottom:auto;
					margin-right:auto;
				}
				</style>
				<div id='wrap'>
			".$model->text."</div>";
		fwrite($fp, $data);
		fclose($fp);
		$link=CHtml::link(Yii::t('app','Download').'!',Yii::app()->request->baseUrl."/doc.html");
		$this->render('export',array(
			'model'=>$model,
			'link'=>$link,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$perm=$model->editPermissions;
		$pieces=explode(", ",$perm);
		if(Yii::app()->user->getName()=='admin' || Yii::app()->user->getName()==$model->createdBy || array_search(Yii::app()->user->getName(),$pieces)!=false || Yii::app()->user->getName()==$perm){  
			if(isset($_POST['DocChild']))
			{
				$model->attributes=$_POST['DocChild'];
                                
                                $model->text=$_POST['msgpost'];
                                $model=$this->updateChangeLog($model,'Edited');
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}

			$this->render('update',array(
				'model'=>$model,
			));
		
		}else{
			$this->redirect(array('view','id'=>$id));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new DocChild('search');
		$name="Docs";
		parent::actionIndex($model,$name);
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DocChild('search');
		$name='DocChild';
		parent::actionAdmin($model,$name);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model = CActiveRecord::model('DocChild')->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='docs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
