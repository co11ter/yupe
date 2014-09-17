<header data-stuck="250" data-offset-top="150" class=""><!--data-offset-top is when header converts to small variant and data-stuck when it becomes visible. Values in px represent position of scroll from top. Make sure there is at least 100px between those two values for smooth animation-->

    <!--Search Form-->
    <form autocomplete="off" role="form" method="get" class="search-form closed">
        <div class="container">
            <div class="close-search"><i class="icon-delete"></i></div>
            <div class="form-group">
                <label for="search-hd" class="sr-only">Search for procuct</label>
                <input type="text" placeholder="Search for procuct" id="search-hd" name="search-hd" class="form-control">
                <button type="submit"><i class="icon-magnifier"></i></button>
            </div>
        </div>
    </form>

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
                    'name' => 'main',
                    'layoutParams' => array('class' => 'main')
                )); ?>
                <?php $this->widget('application.modules.menu.widgets.MenuWidget', array(
                    'name' => 'catalog',
                    'layoutParams' => array('class' => 'catalog')
                )); ?>
            <?php } endif; ?>
        </nav>

        <!--Toolbar-->
        <div class="toolbar group">
            <button class="search-btn btn-outlined-invert"><i class="icon-magnifier"></i></button>
            <div class="middle-btns">
                <a href="wishlist.html" class="btn-outlined-invert"><i class="icon-heart"></i> <span>Wishlist</span></a>
                <a data-target="#loginModal" data-toggle="modal" href="#" class="login-btn btn-outlined-invert"><i class="icon-profile"></i> <span>Login</span></a>
            </div>
            <div class="cart-btn">
                <?php $this->widget('application.modules.shop.widgets.ShoppingCartWidget'); ?>
            </div>
        </div><!--Toolbar Close-->
    </div>
</header>