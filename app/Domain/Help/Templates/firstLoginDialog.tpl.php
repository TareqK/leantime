<?php

use Leantime\Core\Theme;

foreach ($__data as $var => $val) {
    $$var = $val; // necessary for blade refactor
}
    $step = $tpl->get("currentStep");
?>

<?php

if (isset($_GET['step']) && $_GET['step'] == "complete") {?>
    <script>
        jQuery.nmTop().close();
    </script>
<?php } ?>



<?php if ($step == 1) { ?>
    <form class="onboardingModal step1" method="post" action="<?=BASE_URL ?>/help/firstLogin?step=2">

        <input type="hidden" name="step" value="1" />
        <div class="row">
            <div class="col-md-6">
                <h1><?=$tpl->__('headlines.hi_there'); ?></h1>
                <p><?=$tpl->__('text.first_login_intro') ?></p>
                <br />
                <label><?=$tpl->__('label.name_your_first_project') ?></label>
                <input type="text" id="projectName" name="projectname" value="" placeholder=""/><br />
                <input type="submit" value="<?=$tpl->__('buttons.next') ?>"/>
                <a href="javascript:void(0);"  onclick="skipOnboarding();"><?=$tpl->__('links.skip_for_now') ?></a>
           </div>
            <div class="col-md-6">
                <div class='svgContainer' style="width:300px">
                    <?= file_get_contents(ROOT . "/dist/images/svg/undraw_game_day_ucx9.svg"); ?>
                </div>
            </div>

        </div>

    </form>
<?php } ?>

<?php if ($step == 2) { ?>
    <form class="onboardingModal step2" method="post" action="<?=BASE_URL ?>/help/firstLogin?step=3">
        <input type="hidden" name="step" value="2" />
        <div class="row">
            <div class="col-md-6">
                <h1><?=$tpl->__('headlines.your_theme'); ?></h1>
                <p><?=$tpl->__('text.theme_choice') ?></p>
                <br />
                <br />
                <select name="theme" id="theme" style="width: 220px">
                    <?php
                    $themeCore = app()->make(Theme::class);
                    $themeAll = $themeCore->getAll();
                    foreach ($themeAll as $key => $name) {
                        ?>
                        <option value="<?=$key ?>" <?php if ($key == 'default') {
                            echo "selected='selected'";
                                       } ?>><?=$tpl->__($name) ?></option>
                    <?php } ?>
                </select>
                <br /><br />
                <input type="submit" value="<?=$tpl->__('buttons.next') ?>"/>
            </div>
            <div class="col-md-6">
                <div class='svgContainer' style="width:300px">
                    <?= file_get_contents(ROOT . "/dist/images/svg/undraw_dark_mode_2xam.svg"); ?>
                </div>
            </div>
        </div>
    </form>

<?php } ?>

<?php if ($step == 3) { ?>
    <form class="onboardingModal step2" method="post" action="<?=BASE_URL ?>/help/firstLogin?step=3">
        <input type="hidden" name="step" value="3" />
        <div class="row">
            <div class="col-md-6">
                <h1><?=$tpl->__('headlines.invite_crew'); ?></h1>
                <p><?=$tpl->__('text.invite_team') ?></p>
                <br />
                <input type="email" name="email1" value="" placeholder="<?=$tpl->__('input.placeholder.email_invite');?>" style="width: 100%;"/><br />
                <input type="email" name="email2" value="" placeholder="<?=$tpl->__('input.placeholder.email_invite');?>" style="width: 100%;"/><br />
                <input type="email" name="email3" value="" placeholder="<?=$tpl->__('input.placeholder.email_invite');?>" style="width: 100%;"/><br />
                <br />
                <input type="submit" value="<?=$tpl->__('buttons.lets_go') ?>"/>
                <a href="javascript:void(0);"  onclick="jQuery.nmTop().close();"><?=$tpl->__('links.skip_for_now') ?></a>
            </div>
            <div class="col-md-6">
                <div class='svgContainer' style="width:300px; margin-top:60px;">
                    <?= file_get_contents(ROOT . "/dist/images/svg/undraw_children_re_c37f.svg"); ?>
                </div>
            </div>
        </div>
    </form>

<?php } ?>


<script>
    jQuery(document).ready(function(){
        jQuery("#theme").on("change", function(){
            var themeName = jQuery("#theme option:selected").val();
            var url = "<?php echo BASE_URL; ?>/theme/"+themeName+"/css/theme.css";
            jQuery("#themeStylesheet").attr("href", url);
        });



    });

    function skipOnboarding() {

        jQuery("form.step1 #projectName").val('<?=$_SESSION["currentProjectName"] ?? '' ?>');
        jQuery("form.step1").submit();
        jQuery.nmTop().close();

    }
</script>


