<?php
namespace Nebula\Layouts;

use Nebula\NebulaTheme;
use PHPFusion\Panels;

class MainFrame extends NebulaTheme {

    public function __construct() {
        if ($this->getParam('header') === TRUE) {
            $this->NebulaHeader();
            add_to_footer("<script src='".THEME."assets/js/jquery.nicescroll.min.js'></script>");
            add_to_footer("<script src='".THEME."assets/js/wow.min.js'></script>");
            /* add_to_jquery("
            $('html').niceScroll({
                touchbehavior: false,
                cursorborder: 'none',
                cursorwidth: '8px',
                background: '#666',
                zindex: '999'
            });
            "); */
        }

        $this->NebulaBody();

        if ($this->getParam('footer') === TRUE) {
            $this->NebulaFooter();
        }
    }

    private function NebulaHeader() {
        echo renderNotices(getNotices(array('all', FUSION_SELF)));
        ?>
        <header <?php echo($this->getParam('headerBg') === TRUE ? " class=\"headerBg\"" : "") ?>>
            <div class="headerInner">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <div class="logo">
                                    <a href="<?php echo BASEDIR.fusion_get_settings('opening_page') ?>"
                                       title="<?php echo fusion_get_settings('site_name') ?>">
                                        <img src="<?php echo BASEDIR.fusion_get_settings('sitebanner') ?>" alt=""/>
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                <div class="navbar-header navbar-right">
                                    <ul class="navbar-nav">
                                        <?php if (iMEMBER) : ?>
                                            <li><a href="<?php echo BASEDIR."members.php" ?>">Members</a></li>
                                            <?php if (iADMIN) : ?>
                                                <li><a href="<?php echo ADMIN."index.php".fusion_get_aidlink() ?>" title="Administration Panel">Administration
                                                        Panel</a></li>
                                            <?php endif; ?>
                                            <li><a href="<?php echo FUSION_SELF."?logout=yes" ?>">Logout</a></li>
                                        <?php else: ?>
                                            <li><a href="<?php echo BASEDIR."register.php" ?>">Register</a></li>
                                            <li><a href="<?php echo BASEDIR."login.php" ?>">Login</a></li>
                                        <?php endif; ?>
                                        <li><a href="">Set your language</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php echo showsublinks('', '', array(
                                'id' => 'NebulaHeader',
                                'container' => TRUE,
                            'class' => 'navbar-default',
                            'links_per_page' => 8,
                            'links_grouping' => TRUE,
                            )).
                            // do affix
                            add_to_jquery("
                        $('#NebulaHeader').affix({
                          offset: {
                            top: 100,
                            bottom: function () {
                              return (this.bottom = $('.footer').outerHeight(true))
                            }
                          }
                        })
                        ");
                        ?>
                <?php if (AU_CENTER || ($this->getParam('header_content'))) : ?>
                    <div class="nebulaHeader">
                        <?php echo($this->getParam('header_content') ?: "") ?>
                                <?php echo AU_CENTER; ?>
                            </div>
                        <?php endif; ?>
                </div>
        </header>
        <?php
    }

    private function NebulaBody() {

        if ($this->getParam('subheader_content') || $this->getParam('breadcrumbs') === TRUE) : ?>
            <div class="nebulaSubheader">
                <div class="container">
                    <?php if ($this->getParam('subheader_content')) : ?>
                        <h4 class="display-inline-block"><?php echo $this->getParam('subheader_content') ?></h4>
                    <?php endif; ?>
                    <?php if ($this->getParam('breadcrumbs') === TRUE) :
                        echo render_breadcrumbs();
                    endif;
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (U_CENTER) : ?>
            <section class="nebulaContentTop">
                <div class="container">
                    <?php echo U_CENTER; ?>
                </div>
            </section>
        <?php endif; ?>
        <?php
        $side_span = 3;
        $main_span = 12;
        if (RIGHT) {
            if (RIGHT) {
                $main_span = $main_span - $side_span;
            }
        }
        ?>

        <?php if (LEFT) : ?>
            <div class="nebulaCanvas off">
                <a class='canvas-toggle' href='#' data-target='nebulaCanvas'>
                    <i class='fa fa-bars fa-lg'></i>
                </a>
                <?php echo LEFT ?>
            </div>
            <?php
            add_to_jquery("
            $('.canvas-toggle').bind('click',function(){
             var target = $(this).data('target');
             $('.'+target).toggleClass('off');
            });
            ");

            ?>
        <?php endif; ?>

        <?php if ($this->getParam('container') == TRUE) : ?>
        <section class="nebulaBody">
            <div class="container">
        <?php endif; ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-<?php echo $main_span ?>">
                        <?php echo CONTENT ?>
                    </div>
                    <?php if (RIGHT || $this->getParam('right_pre_content') || $this->getParam('right_post_content')) : ?>
                        <div class="col-xs-12 col-sm-<?php echo $side_span ?>">
                            <?php echo $this->getParam('right_pre_content').RIGHT.$this->getParam('right_post_content') ?>
                        </div>
                    <?php endif; ?>
                </div>
        <?php if ($this->getParam('container') === TRUE) : ?>
            </div>
        </section>
        <?php
        endif;
    }

    private function NebulaFooter() {
        ?>
        <section class="nebulaFooter">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-3">
                        <h4>About Us</h4>
                        <p>
                            <?php echo fusion_get_settings('description') ?>
                        </p>
                        <?php echo stripslashes(strip_tags(fusion_get_settings('footer'))) ?>
                        <p><?php echo showcopyright() ?></p>
                        <?php if (fusion_get_settings('visitorcounter_enabled')) : echo "<p>".showcounter()."</p>\n"; endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-3">

                    </div>
                    <div class="col-xs-12 col-sm-3">

                    </div>
                    <div class="col-xs-12 col-sm-3">

                    </div>
                </div>


                <a href="#top" class="pull-right"><i class="fa fa-chevron-up fa-3x"></i></a>


            </div>
        </section>
        <section class="nebulaCopyright">
            <div class="container">
                <div class="col-xs-12 col-sm-4">
                    <h4 class="text-white">Nebula Theme by <a href='https://www.php-fusion.co.uk/profile.php?lookup=16331' target='_blank'>PHP-Fusion
                            Inc</a></h4>
                </div>

                <p>
                    <?php
                    if (fusion_get_settings('rendertime_enabled') == '1' || fusion_get_settings('rendertime_enabled') == '2') :
                        echo showrendertime();
                        echo showMemoryUsage();
                    endif;
                    $footer_errors = showFooterErrors();
                    if (!empty($footer_errors)) : echo $footer_errors; endif;
                    ?>
                </p>
            </div>
        </section>
        <?php
    }


}