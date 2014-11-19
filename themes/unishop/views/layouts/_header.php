<header data-stuck="250" data-offset-top="150" class=""><!--data-offset-top is when header converts to small variant and data-stuck when it becomes visible. Values in px represent position of scroll from top. Make sure there is at least 100px between those two values for smooth animation-->

    <!--Split Background-->
    <div class="left-bg"></div>
    <div class="right-bg"></div>

    <div class="container">
        <a href="/" class="logo">
            <?php echo CHtml::image(
                Yii::app()->getTheme()->getAssetsUrl() . '/images/logo.png',
                Yii::app()->name,
                array(
                    'width'  => '38',
                    'height' => '38',
                    'title'  => Yii::app()->name,
                )
            );?>
        </a>

        <!--Mobile Menu Toggle-->
        <div class="menu-toggle"><i class="fa fa-list"></i></div>
        <div class="mobile-border"><span></span></div>

        <!--Main Menu-->

        <nav class="menu">
            <?php if (Yii::app()->hasModule('menu')): { ?>
                <?php $this->widget('application.modules.menu.widgets.MenuWidget', array(
                    'name' => 'top-menu',
                    'layoutParams' => array('class' => 'main')
                )); ?>
                <?php $this->widget('application.modules.menu.widgets.MenuWidget', array(
                    'name' => 'catalog',
                    'layoutParams' => array('class' => 'catalog')
                )); ?>
            <?php } endif; ?>
        </nav>

        <!--Toolbar-->
        <div class="toolbar group search-bar">
            <div class="middle-btns">
                <a class="login-btn btn-outlined-invert" href="/backend"><i class="icon-profile"></i> <span>Войти</span></a>
            </div>

            <div class="cart-btn">
                <?php
                if (Yii::app()->hasModule('shop') && Yii::app()->getModule('shop')) {
                    $this->widget('application.modules.shop.widgets.ShoppingCartWidget');
                } ?>
            </div>

            <form class="search-btn btn-outlined-invert" method="get" role="form" autocomplete="off" action="/shop/search">
                <?php echo CHtml::textField(
                    'search-hd',
                    isset($_GET['search-hd']) ? $_GET['search-hd'] : '',
                    array(
                    'class' => 'form-control',
                    'id'    => 'search-hd'
                    )
                ); ?>
                <button type="submit"><i class="icon-magnifier"></i></button>
            </form>

            <div class="phone-label">
                <i class="fa fa-phone"></i> (495) 989-16-39
            </div>

        </div>
        <!--Toolbar Close-->
    </div>
</header>