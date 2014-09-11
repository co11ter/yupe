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
    'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors' => true,
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('AttributeModule.attribute', 'Fields marked with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('AttributeModule.attribute', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow(
            $model,
            'name',
            array(
                'class' => 'span7 popover-help',
                'size' => 60, 'maxlength' => 250,
                'data-original-title' => $model->getAttributeLabel('name'),
                'data-content' => $model->getAttributeDescription('name')
            )
        );?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <div class="span3">
            <?php echo $form->checkBoxListRow(
                $model,
                'categoryIds',
                $model->getCategoryList(),
                array(
                    'class' => 'span3 popover-help',
                    'data-original-title' => $model->getAttributeLabel('category_id'),
                    'data-content' => $model->getAttributeDescription('category_id'),
                    'encode' => false
                )
            );?>
        </div>
        <div class="span3">
            <?php echo $form->checkBoxListRow(
                $model,
                'filtering',
                $model->getCategoryList(),
                array(
                    'class' => 'span3 popover-help',
                    'data-original-title' => $model->getAttributeLabel('filtering'),
                    'data-content' => $model->getAttributeDescription('filtering'),
                    'encode' => false
                )
            );?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('type_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow(
            $model,
            'type_id',
            $model->getTypeList(),
            array(
                'empty' => Yii::t('AttributeModule.attribute', '--choose--'),
                'class' => 'span7 popover-help',
                'data-original-title' => $model->getAttributeLabel('type_id'),
                'data-content' => $model->getAttributeDescription('type_id'),
                'encode' => false
            )
        );?>
    </div>
    <div class="row-fluid control-group value_list hidden <?php echo $model->hasErrors('value_list') ? 'error' : ''; ?>">
        <?php
        if($model->value_list)
            $model->value_list = implode(PHP_EOL, $model->value_list);
        echo $form->textAreaRow(
            $model,
            'value_list',
            array(
                'class' => 'span7 popover-help',
                'size' => 60, 'maxlength' => 250,
                'data-original-title' => $model->getAttributeLabel('value_list'),
                'data-content' => $model->getAttributeDescription('value_list')
            )
        );?>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
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
