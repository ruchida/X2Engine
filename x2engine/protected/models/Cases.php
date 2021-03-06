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

/**
 * This is the model class for table "x2_cases".
 *
 * The followings are the available columns in table 'x2_cases':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $type
 * @property string $priority
 * @property string $assignedTo
 * @property string $endDate
 * @property string $timeframe
 * @property string $createDate
 * @property string $associatedContacts
 * @property string $description
 * @property string $resolution
 * @property string $lastUpdated
 * @property string $updatedBy
 */
class Cases extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cases the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'x2_cases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, status', 'required'),
			array('name', 'length', 'max'=>60),
			array('status, type, priority, updatedBy', 'length', 'max'=>20),
			array('timeframe', 'length', 'max'=>40),
			array('lastUpdated', 'length', 'max'=>30),
			array('assignedTo, endDate, createDate, associatedContacts, description, resolution', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, status, type, priority, assignedTo, endDate, timeframe, createDate, associatedContacts, description, resolution, lastUpdated, updatedBy', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('projects','ID'),
			'name'=>Yii::t('projects','Name'),
			'status'=>Yii::t('projects','Status'),
			'type'=>Yii::t('projects','Type'),
			'priority'=>Yii::t('projects','Priority'),
			'assignedTo'=>Yii::t('projects','Assigned To'),
			'endDate'=>Yii::t('projects','End Date'),
			'timeframe'=>Yii::t('projects','Timeframe'),
			'createDate'=>Yii::t('projects','Create Date'),
			'associatedContacts'=>Yii::t('projects','Associated Contacts'),
			'description'=>Yii::t('projects','Description'),
			'resolution'=>Yii::t('projects','Resolution'),
			'lastUpdated'=>Yii::t('projects','Last Updated'),
			'updatedBy'=>Yii::t('projects','Updated By'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('assignedTo',$this->assignedTo,true);
		$criteria->compare('endDate',$this->endDate,true);
		$criteria->compare('timeframe',$this->timeframe,true);
		$criteria->compare('createDate',$this->createDate,true);
		$criteria->compare('associatedContacts',$this->associatedContacts,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('resolution',$this->resolution,true);
		$criteria->compare('lastUpdated',$this->lastUpdated,true);
		$criteria->compare('updatedBy',$this->updatedBy,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}