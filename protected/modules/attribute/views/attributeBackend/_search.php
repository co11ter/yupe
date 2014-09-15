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

<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'name',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class' => ' popover-help',
                            'data-original-title' => $model->getAttributeLabel('name'),
                            'data-content' => $model->getAttributeDescription('name')
                        )
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'type_id',
                array(
                    'widgetOptions' => array(
                        'data' => $model->getTypeList(),
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('type_id'),
                            'data-content' => $model->getAttributeDescription('type_id'),
                            'empty' => Yii::t('AttributeModule.attribute', '--choose--'),
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('AttributeModule.attribute', 'Find a attribute'),
    )
); ?>

<?php $this->endWidget(); ?>
