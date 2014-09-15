<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language; ?>">
<head prefix="og: http://ogp.me/ns#
    fb: http://ogp.me/ns/fb#
    article: http://ogp.me/ns/article#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1">
    <meta charset="<?php echo Yii::app()->charset; ?>"/>
    <meta name="keywords" content="<?php echo CHtml::encode($this->keywords); ?>"/>
    <meta name="description" content="<?php echo CHtml::encode($this->description); ?>"/>
    <meta property="og:title" content="<?php echo CHtml::encode($this->pageTitle); ?>"/>
    <meta property="og:description" content="<?php echo $this->description; ?>"/>
    <?php
    $mainAssets = Yii::app()->getTheme()->getAssetsUrl();

    //    Yii::app()->clientScript->registerCssFile($mainAssets . '/css/yupe.css');
    //    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/blog.js');
    //    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/bootstrap-notify.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.li-translit.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/modernizr.custom.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.easing.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/smoothscroll.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.validate.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/icheck.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.placeholder.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.stellar.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.touchSwipe.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.shuffle.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/lightGallery.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/owl.carousel.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/masterslider.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/jquery.nouislider.min.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/script.js');
    Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/color-switcher.js');

    ?>
    <script type="text/javascript">
        var yupeTokenName = '<?php echo Yii::app()->getRequest()->csrfTokenName;?>';
        var yupeToken = '<?php echo Yii::app()->getRequest()->csrfToken;?>';
    </script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
<!-- header -->
<?php $this->renderPartial('//layouts/_header'); ?>
<!-- header end -->

<!-- container -->
<div class='page-content'>
    <!-- flashMessages -->
    <?php $this->widget('yupe\widgets\YFlashMessages'); ?>
    <!-- breadcrumbs -->
    <?php $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        array(
            'links' => $this->breadcrumbs,
        )
    );?>

    <!-- content -->
    <?php echo $content; ?>
    <!-- content end-->

    <!-- template buttons -->
    <div class="sticky-btns scrolled">
        <form name="quick-contact" method="post" class="quick-contact" novalidate="novalidate">
            <h3>Contact us</h3>

            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do.</p>

            <div class="form-group">
                <label for="qc-name">Full name</label>
                <input type="text" required="" placeholder="Enter full name" id="qc-name" name="qc-name"
                       class="form-control input-sm">
            </div>
            <div class="form-group">
                <label for="qc-email">Email</label>
                <input type="email" required="" placeholder="Enter email" id="qc-email" name="qc-email"
                       class="form-control input-sm">
            </div>
            <div class="form-group">
                <label for="qc-message">Your message</label>
                <textarea required="" placeholder="Enter your message" id="qc-message" name="qc-message"
                          class="form-control input-sm"></textarea>
            </div>
            <input type="submit" value="Send" class="btn btn-success btn-sm btn-block">
        </form>
        <span id="qcf-btn" class=""><i class="fa fa-envelope"></i></span>
        <span id="scrollTop-btn"><i class="fa fa-chevron-up"></i></span>
    </div>
    <!-- template buttons end -->


</div>
<div class='notifications top-right' id="notifications"></div>
<!-- container end -->

<!-- footer -->
<?php $this->renderPartial('//layouts/_footer'); ?>
<!-- footer end -->
<?php if (Yii::app()->hasModule('contentblock')): { ?>
    <?php $this->widget(
        "application.modules.contentblock.widgets.ContentBlockWidget",
        array("code" => "STAT", "silent" => true)
    ); ?>
<?php } endif; ?>
</body>
</html>
