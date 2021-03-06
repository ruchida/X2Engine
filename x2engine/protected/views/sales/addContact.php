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

$this->menu=array(
	array('label'=>Yii::t('sales','Sales List'), 'url'=>array('index')),
	array('label'=>Yii::t('sales','Create Sale'), 'url'=>array('create')),
	array('label'=>Yii::t('sales','View Sale'), 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>Yii::t('sales','Update Sale'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('sales','Add A User'), 'url'=>array('addUser', 'id'=>$model->id)),
	array('label'=>Yii::t('sales','Add A Contact'), 'url'=>($action=='Add')?null:array('addContact', 'id'=>$model->id)),
	array('label'=>Yii::t('sales','Remove A User'), 'url'=>array('removeUser', 'id'=>$model->id)),
	array('label'=>Yii::t('sales','Remove A Contact'), 'url'=>($action=='Remove')?null:array('removeContact', 'id'=>$model->id)),
);
?>

<h2><?php echo Yii::t('sales','Update Sale:'); ?> <b><?php echo $model->name; ?></b></h2>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'acocunts-form',
	'enableAjaxValidation'=>false,
)); 
echo ($action=='Remove')? Yii::t('sales','Please select the contacts you wish to remove.') : Yii::t('sales','Please select the contacts you wish to add.');
?>
<br /><br />
<div class="row">
	<?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'name'=>'auto_select',
				'source' => $this->createUrl('contacts/getContacts'),
				'htmlOptions'=>array('size'=>25,'maxlength'=>100,'tabindex'=>3),
				'options'=>array(
					'minLength'=>'2',
					'select'=>'js:function( event, ui ) {
						$("#'.CHtml::activeId($model,'associatedContacts').'").val(ui.item.id);
						$(this).val(ui.item.value);
						return false;
					}',
				),
			)); ?><br />
	<?php echo $form->dropDownList($model,'associatedContacts',$contacts,array("multiple"=>"multiple", 'size'=>8)); ?>
	<?php echo $form->error($model,'associatedContacts'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton(Yii::t('sales',$action),array('class'=>'x2-button')); ?>
</div>

<?php $this->endWidget(); ?>

</div>