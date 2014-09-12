<script type='text/javascript'>
    function createAttribute(obj) {
        var select = $('#Good_goodAttributes'),
            outer, label;

        if(select.find('option[value="' + obj.id + '"]').length==0) {
            return false;
        }

        <?php // TODO преписать дальнейший говнокод ?>
        select.find('option[value="' + obj.id + '"]').remove();
        select.parent().append('<label for="Good_goodAttributes_' + obj.id + '">' + obj.name + '</label>');
        if(obj.type_id == <?php echo Attribute::TYPE_LIST;?>) {
            outer = $('<select>')
                .addClass('span7 popover-help')
                .attr({
                    id: 'Good_goodAttributes_' + obj.id,
                    name: 'Good[goodAttributes][' + obj.id + ']',
                    type: 'text'
                });
            select.parent().append(outer);
            outer.append($('<option>')
                .attr('value', '')
                .html('--choose--')
            );
//            obj.value_list = obj.value_list.split('\n');
            $.each(obj.value_list, function(key, value) {
                outer.append($('<option>')
                    .attr('value', value)
                    .html(value)
                );
            });
        } else if(obj.type_id == <?php echo Attribute::TYPE_MULTIPLE_LIST;?>) {
            outer = $('<span>').attr('id', 'Good_goodAttributes_' + obj.id);
            select.parent().append(outer);
//            obj.value_list = obj.value_list.split('\n');
            $.each(obj.value_list, function(key, value) {
                label = $('<label>').addClass('checkbox');
                outer.append(label);
                label.append($('<input>')
                    .addClass('span7 popover-help')
                    .attr({
//                        id: 'Good_goodAttributes_' + obj.id,
                        name: 'Good[goodAttributes][' + obj.id + '][]',
                        value: value,
                        type: 'checkbox'
                    })
                );
                label.html(label.html() + value);
            });
        } else {
            select.parent().append($('<input>')
                .addClass('span7 popover-help')
                .attr({
                    id: 'Good_goodAttributes_' + obj.id,
                    name: 'Good[goodAttributes][' + obj.id + ']',
                    type: 'text'
                })
            );
        }
        return false;
    }
    $(document).ready(function(){
        $('#good-form').liTranslit({
            elName: '#Good_name',
            elAlias: '#Good_alias'
        });
        $('#Good_goodAttributes').on('change', function(event){
            var option = $(this).find('option:selected');
            var obj = {
                id: option.val(),
                name: option.text(),
                type_id: option.data().type_id,
                value_list: option.data().value_list.split('\n')
            };
            createAttribute(obj);
        });
        $('#Good_category_id').on('change', function(event){
            $.get(
                '/backend/attribute/attribute',
                {
                    type: 'json',
                    Attribute: {
                        categoryIds: [$(this).val()]
                    }
                },
                function(data){
                    var obj = JSON.parse(data);
                    $.each(obj, function(key, value) {
                        createAttribute(value);
                    });
                }
            );
        });
    })
</script>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'good-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('ShopModule.shop', 'Fields marked with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('ShopModule.shop', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-4">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('status'),
                            'data-content'        => $model->getAttributeDescription('status')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <br/>
            <?php echo $form->checkBoxGroup(
                $model,
                'is_special',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('is_special'),
                            'data-content'        => $model->getAttributeDescription('is_special')
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
                            'empty'               => Yii::t('ShopModule.catalog', '--choose--'),
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
            <?php echo $form->textFieldGroup(
                $model,
                'price',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('price'),
                            'data-content'        => $model->getAttributeDescription('price')
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
            <?php
            echo CHtml::image(
                !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
                $model->name,
                array(
                    'class' => 'preview-image',
                    'style' => !$model->isNewRecord && $model->image ? '' : 'display:none'
                )
            ); ?>
            <?php echo $form->fileFieldGroup(
                $model,
                'image',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'onchange' => 'readURL(this);',
                            'style'    => 'background-color: inherit;'
                        )
                    )
                )
            ); ?>
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
            <div class="popover-help form-group" data-original-title='<?php echo $model->getAttributeLabel('data'); ?>'
                 data-content='<?php echo $model->getAttributeDescription('data'); ?>'>
                <?php echo $form->labelEx($model, 'data'); ?>
                <?php $this->widget($this->module->editor, array(
                    'model' => $model,
                    'attribute' => 'data',
                    'options' => $this->module->editorOptions,
                )); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <?php
        $options = array();
        foreach(Attribute::model()->findAll() as $val) {
            $options[CHtml::value($val, 'id')] = array(
                'data-type_id' => CHtml::value($val, 'type_id'),
                'data-value_list' => implode(PHP_EOL, CHtml::value($val, 'value_list'))
            );
        }
        $attrs = CHtml::listData(Attribute::model()->findAll(), 'id', 'name');
        if($model->goodAttributes) {
            foreach($model->goodAttributes as $m) {
                if(isset($attrs[$m->attribute_id])) {
                    unset($attrs[$m->attribute_id]);
                }
            }
        }
        echo $form->dropDownListGroup(
            $model,
            'goodAttributes',
            array(
                'widgetOptions' => array(
                    'data'        => $attrs,
                    'htmlOptions' => array(
                        'empty' => Yii::t('ShopModule.shop', '--choose--'),
                        'class' => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('goodAttributes'),
                        'data-content' => $model->getAttributeDescription('goodAttributes'),
                        'encode' => false,
                        'options' => $options
                    ),
                ),
            )
        ); ?>

        <?php //TODO Временное решение. Переписать?>
        <?php if($model->goodAttributes) {
            $is_output = array();
            foreach($model->goodAttributes as $m) {
                if(in_array($m->attribute->id, $is_output))
                    continue;
                ?>
                <label for="Good_goodAttributes_<?php echo $m->attribute->id;?>"><?php echo $m->attribute->name;?></label>
                <?php
                switch((int)$m->attribute->type_id){
                    case Attribute::TYPE_LIST:
                        ?>
                        <select
                            id="Good_goodAttributes_<?php echo $m->attribute->id; ?>"
                            name="Good[goodAttributes][<?php echo $m->attribute->id; ?>]"
                            class="span7 popover-help"
                            >
                            <option value="">--choose--</option>
                            <?php foreach ($m->attribute->value_list as $value): ?>
                                <option
                                    value="<?php echo $value ?>"<?php if ($value == $m->value) echo ' selected="selected"' ?>>
                                    <?php echo $value ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php
                        break;
                    case Attribute::TYPE_MULTIPLE_LIST:
                        $list = CHtml::listData($model->goodAttributes, 'id', 'value', 'attribute_id');
                        ?>
                        <span id="Good_goodAttributes_<?php echo $m->attribute->id; ?>">
                            <?php foreach (/*$list[$m->attribute->id]*/$m->attribute->value_list as $value): ?>
                                <label class="checkbox">
                                    <input type="checkbox" class="span7 popover-help"
                                           name="Good[goodAttributes][<?php echo $m->attribute->id; ?>][]"
                                           value="<?php echo $value; ?>"
                                           <?php if (in_array($value, $list[$m->attribute->id])) echo ' checked' ?>>
                                    <?php echo $value ?>
                                </label>
                            <?php endforeach; ?>
                        </span>
                        <?php
                        break;
                    default:
                        ?>
                            <input type="text" class="span7 popover-help"
                                   id="Good_goodAttributes_<?php echo $m->attribute->id; ?>"
                                   name="Good[goodAttributes][<?php echo $m->attribute->id; ?>]">
                        <?php
                }
            $is_output[] = $m->attribute->id;
            }
        } ?>
        </div>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'context'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('ShopModule.shop', 'Add product and continue') : Yii::t('ShopModule.shop', 'Save product and continue'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('ShopModule.shop', 'Add product and close') : Yii::t('ShopModule.shop', 'Save product and close'),
    )); ?>

<?php $this->endWidget(); ?>