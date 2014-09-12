<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="info">
                    <a href="index.html" class="logo"><img alt="Bushido" src="img/logo.png"></a>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                    <div class="social">
                        <a target="_blank" href="#"><i class="fa fa-instagram"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-youtube-square"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-tumblr-square"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-vimeo-square"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-pinterest-square"></i></a>
                        <a target="_blank" href="#"><i class="fa fa-facebook-square"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2>Latest news</h2>
                <ul class="list-unstyled">
                    <li>25 May <a href="#">Nemo enim ipsam voluptatem</a></li>
                    <li>01 May <a href="#">Neque porro quisquam est</a></li>
                    <li>16 Apr <a href="#">Lorem ipsum dolor sit amet</a></li>
                    <li>10 Jan <a href="#">Sed ut perspiciatis unde</a></li>
                </ul>
            </div>
            <div class="contacts col-lg-3 col-md-3 col-sm-3">
                <h2>Contacts</h2>
                <p class="p-style3">
                    4120 Lenox Avenue, New York, NY,<br>
                    10035 76 Saint Nicholas Avenue<br>
                    <a href="mailto:mail@bushido.com">mail@bushido.com</a><br>
                    +48 543765234<br>
                    +48 555 234 54 34<br>
                </p>
            </div>
        </div>
        <div class="copyright">
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <p>&copy; 2014 BUSHIDO. All Rights Reserved. Designed by <a target="_blank" href="http://8guild.com/">8Guild</a></p>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <div class="payment">
                        <?php echo CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . '/images/visa.png', 'Visa');?>
                        <?php echo CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . '/images/paypal.png', 'PayPal');?>
                        <?php echo CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . '/images/master.png', 'Master Card');?>
                        <?php echo CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . '/images/discover.png', 'Discover');?>
                        <?php echo CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . '/images/amazon.png', 'Amazon');?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
