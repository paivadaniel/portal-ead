<?php

require_once('cabecalho.php');

?>

    <section id="about-page-section-3">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-7 text-align">
                    <div class="section-heading">
                        <h2>Sobre <span>Nós</span></h2>
                        <p class="subheading">Lorem ipsum send do tempor consectetur ipsum send do tempor.</p>
                    </div>
                    <p>
                        Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh etlibura. Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh
                        etlibura. Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh etlibura.

                        <br><br> Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consec tetuer adipis elit, aliquam eget nibh etlibura. Aenean commodo ligula eget dolor. Aenean massa. Lorem ipsum dolor sit amet, consec tetuer
                        adipis elit, aliquam eget nibh etlibura.

                    </p>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                    <!-- <img height="" width="auto" src="img/iphone62.png" class="attachment-full img-responsive" alt="">
                    -->

                    <?php if($video_sobre != '') {

                     ?>
                    <iframe width="100%" height="280" src="<?php echo $video_sobre ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                    <!-- video_sobre é uma variável global, definida em conexao.php, que está dentro de cabecalho.php, cujo require é feito no início dessa página -->

                    <?php }
                    ?>

                </div>



            </div>
        </div>
    </section>


    <section id="features-page">
        <div class="subsection1">
            <div class="container">
                <div class="section-heading text-center">
                    <h1>Our <span>Features</span></h1>
                    <p class="subheading">Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut.</p>
                </div>
                <div class="col sm_12">
                    <div class="col-sm-4 wpb_column block">
                        <div class="wpb_wrapper">
                            <div class="flip">
                                <div class="iconbox iconbox-style icon-color card clearfix">
                                    <div class="face front">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-laptop boxicon"></i>
                                                        <h3>100% Responsive</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="iconbox-box2 face back">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h3>100% Responsive</h3>
                                                        <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 wpb_column block">
                        <div class="wpb_wrapper">
                            <div class="flip">
                                <div class="iconbox  iconbox-style icon-color card clearfix">
                                    <div class="iconbox-box1 face front">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-bullhorn boxicon"></i>
                                                        <h3>Powerful Features</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="iconbox-box2 face back">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h3>Powerful Features</h3>
                                                        <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 wpb_colum block">
                        <div class="wpb_wrapper">
                            <div class="flip">
                                <div class="iconbox  iconbox-style icon-color card clearfix">
                                    <div class="iconbox-box1 face front">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <i class="fa fa-support boxicon"></i>
                                                        <h3>Customer Support</h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="iconbox-box2 face back">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <h3>Customer Support</h3>
                                                        <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="subsection2">
            <div class="container">
                <div class="col-xs-12 col-sm_12 col-md-12 col-lg-12 left">
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 wpb_column">
                        <div class="wpb_wrapper">
                            <h3>We really love what we do & our work on every project truly reflects that.</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 wpb_column block">
                        <div class="wpb_wrapper">
                            <div class="iconbox iconbox-style-2 icon-color clearfix">
                                <div class="iconbox-icon">
                                    <i class="fa fa-lightbulb-o sl-layers boxicon"></i>
                                </div>
                                <div class="iconbox-content">
                                    <h4>IDEA</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                            <div class="spacer"></div>
                            <div class="iconbox iconbox-style-2 icon-color clearfix">
                                <div class="iconbox-icon">
                                    <i class="fa fa-magic sl-book-open boxicon"></i>
                                </div>
                                <div class="iconbox-content nomargin">
                                    <h4>DESIGN</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 wpb_column">
                        <div class="wpb_wrapper">
                            <div class="iconbox iconbox-style-2 icon-color clearfix">
                                <!-- icon-color-greyscale -->
                                <div class="iconbox-icon">
                                    <i class="fa fa-cloud-download sl-badge boxicon"></i>
                                </div>
                                <div class="iconbox-content">
                                    <h4>CONCEPT</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                            <div class="spacer"></div>
                            <div class="iconbox iconbox-style-2 icon-color clearfix">
                                <div class="iconbox-icon">
                                    <i class="fa fa-cog sl-check boxicon"></i>
                                </div>
                                <div class="iconbox-content nomargin">
                                    <h4>DEVELOP</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior ei ut vix denique fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="subsection3" style=" overflow-x:hidden;">

            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 left-section">
                        <div class="subfeature">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <h1><span>Services that </span>we provide.</h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 right-section right-background">
                        <div class="subfeature">
                            <div class="featureblock">
                                <div class="col-md-2 col-xs-2 icon"><i class="fa fa-laptop feature_icon"></i></div>
                                <div class="col-md-10 col-xs-10">
                                    <h4>100% Responsive</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                            <div class="featureblock">
                                <div class="col-md-2 col-xs-2 icon"><i class="fa fa-bullhorn feature_icon"></i></div>
                                <div class="col-md-10 col-xs-10">
                                    <h4>Powerful Features</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>
                                </div>
                            </div>
                            <div class="featureblock nomargin">
                                <div class="col-md-2 col-xs-2 icon"><i class="fa fa-support feature_icon"></i></div>
                                <div class="col-md-10 col-xs-10">
                                    <h4>Customer Support</h4>
                                    <p>Lorem ipsum dolor sit amet sit legimus copiosae instructior fierentis ea saperet inimicu ut qui dolor oratio mnesarchum</p>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>


<?php

require_once('rodape.php');

?>