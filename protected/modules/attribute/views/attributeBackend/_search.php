<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<fieldset class="inline">
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'name',
                array(
                    'class' => ' popover-help',
                    'size' => 60,
                    'maxlength' => 60,
                    'data-original-title' => $model->getAttributeLabel('name'),
                    'data-content' => $model->getAttributeDescription('name')
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model,
                'type_id',
                $model->getTypeList(),
                array(
                    'class' => 'popover-help',
                    'data-original-title' => $model->getAttributeLabel('type_id'),
                    'data-content' => $model->getAttributeDescription('type_id'),
                    'empty' => Yii::t('AttributeModule.attribute', '--choose--'),
                )
            ); ?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('AttributeModule.attribute', 'Find a attribute'),
    )
); ?>

<?php $this->endWidget(); ?>
