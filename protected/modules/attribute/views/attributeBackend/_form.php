<?
/**
 * @var $model Attribute
 * @var $this AttributeBackendController
 */
?>

<script type='text/javascript'>
    function checkAttributeType(){
        var type = $('#Attribute_type_id').val();
        // если является списком
        if ($.inArray(+type, [<?php echo $model::TYPE_LIST.','.$model::TYPE_MULTIPLE_LIST?>]) >= 0) {
            $('.value_list').removeClass('hidden');
        } else {
            $('.value_list').addClass('hidden');
        }
    }

    $(document).ready(function () {
        checkAttributeType();
        $('#Attribute_type_id').on('change', checkAttributeType);
    })
</script>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'attribute-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'type' => 'vertical',
    'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data')
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('AttributeModule.attribute', 'Fields marked with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('AttributeModule.attribute', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">

        <?php echo $form->textFieldGroup(
            $model,
            'name',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class' => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('name'),
                        'data-content' => $model->getAttributeDescription('name')
                    ),
                ),
            )
        );?>
            </div>
    </div>
    <div class="row">
        <div class="col-sm-6">

            <?php echo $form->dropDownListGroup(
                $model,
                'target_id',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getTargetList(),
                        'htmlOptions' => array(
//                            'empty' => Yii::t('AttributeModule.attribute', '--choose--'),
                            'class' => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('target_id'),
                            'data-content' => $model->getAttributeDescription('target_id'),
                            'encode' => false
                        ),
                    ),
                )
            );?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->checkBoxListGroup(
                $model,
                'categoryIds',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getCategoryList(),
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('category_id'),
                            'data-content' => $model->getAttributeDescription('category_id'),
                            'encode' => false
                        ),
                    ),
                )
            );?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->checkBoxListGroup(
                $model,
                'filtering',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getCategoryList(),
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('filtering'),
                            'data-content' => $model->getAttributeDescription('filtering'),
                            'encode' => false
                        ),
                    ),
                )
            );?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'type_id',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getTypeList(),
                    'htmlOptions' => array(
                        'empty' => Yii::t('AttributeModule.attribute', '--choose--'),
                        'class' => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('type_id'),
                        'data-content' => $model->getAttributeDescription('type_id'),
                        'encode' => false
                    ),
                ),
            )
        );?>
        </div>
    </div>
    <div class="row value_list hidden">
        <div class="col-sm-6">
        <?php
        if($model->value_list)
            $model->value_list = implode(PHP_EOL, $model->value_list);
        echo $form->textAreaGroup(
            $model,
            'value_list',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class' => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('value_list'),
                        'data-content' => $model->getAttributeDescription('value_list'),
                        'encode' => false
                    ),
                ),
            )
        );?>
            </div>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord
                ? Yii::t('AttributeModule.attribute', 'Add attribute and continue')
                : Yii::t('AttributeModule.attribute', 'Save attribute and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => $model->isNewRecord
                ? Yii::t('AttributeModule.attribute', 'Add attribute and close')
                : Yii::t('AttributeModule.attribute', 'Save attribute and close'),
    )); ?>

<?php $this->endWidget(); ?>
