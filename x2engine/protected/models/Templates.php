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
 * This is the model class for table "x2_template".
 *
 * The followings are the available columns in table 'x2_template':
 * @property integer $id
 * @property string $assignedTo
 * @property string $name
 * @property string $description
 * @property string $fieldOne
 * @property string $fieldTwo
 * @property string $fieldThree
 * @property string $fieldFour
 * @property string $fieldFive
 * @property integer $createDate
 * @property integer $lastUpdated
 * @property string $updatedBy
 */
class Templates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Template the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'x2_templates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('createDate, lastUpdated', 'numerical', 'integerOnly'=>true),
			array('assignedTo, updatedBy', 'length', 'max'=>40),
			array('name, fieldOne, fieldTwo, fieldThree, fieldFour, fieldFive', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, assignedTo, name, description, fieldOne, fieldTwo, fieldThree, fieldFour, fieldFive, createDate, lastUpdated, updatedBy', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		
		return array(
			'id' => Yii::t('module','ID'),
			'assignedTo' => Yii::t('module','Assigned To'),
			'name' => Yii::t('module','Name'),
			'description' => Yii::t('module','Description'),
			'fieldOne' => Yii::t('module','$fieldOne'),
			'fieldTwo' => Yii::t('module','$fieldTwo'),
			'fieldThree' => Yii::t('module','$fieldThree'),
			'fieldFour' => Yii::t('module','$fieldFour'),
			'fieldFive' => Yii::t('module','$fieldFive'),
			'createDate' => Yii::t('module','Create Date'),
			'lastUpdated' => Yii::t('module','Last Updated'),
			'updatedBy' => Yii::t('module','Updated By'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('assignedTo',$this->assignedTo,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('fieldOne',$this->fieldOne,true);
		$criteria->compare('fieldTwo',$this->fieldTwo,true);
		$criteria->compare('fieldThree',$this->fieldThree,true);
		$criteria->compare('fieldFour',$this->fieldFour,true);
		$criteria->compare('fieldFive',$this->fieldFive,true);
		$criteria->compare('createDate',$this->createDate);
		$criteria->compare('lastUpdated',$this->lastUpdated);
		$criteria->compare('updatedBy',$this->updatedBy,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>ProfileChild::getResultsPerPage(),
			),
		));
	}
}