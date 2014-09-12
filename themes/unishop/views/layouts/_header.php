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
                <a href="shopping-cart.html" class="btn btn-outlined-invert"><i class="icon-shopping-cart-content"></i><span>3</span></a>

                <!--Cart Dropdown-->
                <div class="cart-dropdown">
                    <span></span><!--Small rectangle to overlap Cart button-->
                    <div class="body">
                        <table>
                            <tbody><tr>
                                <th>Items</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                            <tr class="item">
                                <td><div class="delete"></div><a href="#">Good Joo-Joo Surfb</a></td>
                                <td><input type="text" value="1"></td>
                                <td class="price">89 005 $</td>
                            </tr>
                            <tr class="item">
                                <td><div class="delete"></div><a href="#">Good Joo-Joo Item</a></td>
                                <td><input type="text" value="2"></td>
                                <td class="price">4 300 $</td>
                            </tr>
                            <tr class="item">
                                <td><div class="delete"></div><a href="#">Good Joo-Joo</a></td>
                                <td><input type="text" value="5"></td>
                                <td class="price">84 $</td>
                            </tr>
                            </tbody></table>
                    </div>
                    <div class="footer group">
                        <div class="buttons">
                            <a href="checkout.html" class="btn btn-outlined-invert"><i class="icon-download"></i>Checkout</a>
                            <a href="shopping-cart.html" class="btn btn-outlined-invert"><i class="icon-shopping-cart-content"></i>To cart</a>
                        </div>
                        <div class="total">93 389 $</div>
                    </div>
                </div><!--Cart Dropdown Close-->
            </div>
        </div><!--Toolbar Close-->
    </div>
</header>