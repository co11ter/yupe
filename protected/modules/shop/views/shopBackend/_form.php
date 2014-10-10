<script type='text/javascript'>
    $(document).ready(function () {
        $('#good-form').liTranslit({
            elName: '#Good_name',
            elAlias: '#Good_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'good-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('ShopModule.shop', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ShopModule.shop', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'name',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('name'),
                        'data-content'        => $model->getAttributeDescription('name')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'alias',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('alias'),
                        'data-content'        => $model->getAttributeDescription('alias')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            array(
                'widgetOptions' => array(
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => array(
                        'empty'               => Yii::t('ShopModule.shop', '--choose--'),
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('category_id'),
                        'data-content'        => $model->getAttributeDescription('category_id'),
                        'encode'              => false,
                    ),
                ),
            )
        );?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'article',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('article'),
                        'data-content'        => $model->getAttributeDescription('article')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'meta_description',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('meta_description'),
                        'data-content'        => $model->getAttributeDescription('meta_description')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'meta_keywords',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('meta_keywords'),
                        'data-content'        => $model->getAttributeDescription('meta_keywords')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="popover-help form-group"
             data-original-title='<?php echo $model->getAttributeLabel('short_description'); ?>'
             data-content='<?php echo $model->getAttributeDescription('short_description'); ?>'>
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'short_description',
                'options' => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="popover-help form-group" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php
/*        $options = array();
        foreach(Attribute::model()->findAll() as $val) {
            $options[CHtml::value($val, 'id')] = array(
                'data-type_id' => CHtml::value($val, 'type_id'),
                'data-value_list' => implode(PHP_EOL, CHtml::value($val, 'value_list'))
            );
        }
        $attrs = CHtml::listData(Attribute::model()->findAll(), 'id', 'name');
        if($model->offerAttributes) {
            foreach($model->offerAttributes as $m) {
                if(isset($attrs[$m->attribute_id])) {
                    unset($attrs[$m->attribute_id]);
                }
            }
        }
        echo $form->dropDownListGroup(
            $model,
            'offerAttributes',
            array(
                'widgetOptions' => array(
                    'data'        => $attrs,
                    'htmlOptions' => array(
                        'empty' => Yii::t('ShopModule.shop', '--choose--'),
                        'class' => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('offerAttributes'),
                        'data-content' => $model->getAttributeDescription('offerAttributes'),
                        'encode' => false,
                        'options' => $options
                    ),
                ),
            )
        ); */?>

        <?php // TODO Временное решение. Переписать?>
<!--        <?php /*if($model->offerAttributes) {
            $is_output = array();
            foreach($model->offerAttributes as $m) {
                if(in_array($m->attribute->id, $is_output))
                    continue;
                */?>
                <label for="Offer_offerAttributes_<?php /*echo $m->attribute->id;*/?>"><?php /*echo $m->attribute->name;*/?></label>
                <?php
/*                switch((int)$m->attribute->type_id){
                    case Attribute::TYPE_LIST:
                        */?>
                        <select
                            id="Offer_offerAttributes_<?php /*echo $m->attribute->id; */?>"
                            name="Offer[offerAttributes][<?php /*echo $m->attribute->id; */?>]"
                            class="span7 popover-help"
                            >
                            <option value="">--choose--</option>
                            <?php /*foreach ($m->attribute->value_list as $value): */?>
                                <option
                                    value="<?php /*echo $value */?>"<?php /*if ($value == $m->value) echo ' selected="selected"' */?>>
                                    <?php /*echo $value */?>
                                </option>
                            <?php /*endforeach; */?>
                        </select>
                        <?php
/*                        break;
                    case Attribute::TYPE_MULTIPLE_LIST:
                        $list = CHtml::listData($model->offerAttributes, 'id', 'value', 'attribute_id');
                        */?>
                        <span id="Offer_offerAttributes_<?php /*echo $m->attribute->id; */?>">
                            <?php /*foreach ($m->attribute->value_list as $value): */?>
                                <label class="checkbox">
                                    <input type="checkbox" class="span7 popover-help"
                                           name="Offer[offerAttributes][<?php /*echo $m->attribute->id; */?>][]"
                                           value="<?php /*echo $value; */?>"
                                        <?php /*if (in_array($value, $list[$m->attribute->id])) echo ' checked' */?>>
                                    <?php /*echo $value */?>
                                </label>
                            <?php /*endforeach; */?>
                        </span>
                        <?php
/*                        break;
                    default:
                        */?>
                            <input type="text" class="span7 popover-help"
                                   id="Offer_offerAttributes_<?php /*echo $m->attribute->id; */?>"
                                   name="Offer[offerAttributes][<?php /*echo $m->attribute->id; */?>]">
                        --><?php
/*                }
                $is_output[] = $m->attribute->id;
            }
        } */?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('ShopModule.shop', 'Add product and continue') : Yii::t(
                'ShopModule.shop',
                'Save product and continue'
            ),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('ShopModule.shop', 'Add product and close') : Yii::t(
                'ShopModule.shop',
                'Save product and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
