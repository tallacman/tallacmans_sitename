<?php defined('C5_EXECUTE') or exit('Access Denied.');
$app = (isset($app) && $app) ? $app : \Concrete\Core\Support\Facade\Application::getFacadeApplication();
$al = $app->make('helper/concrete/asset_library');
?>

<div class="form-group">
    <?php echo $form->label('displaySitename', t('Site Name')); ?>
    <?php echo $form->text($view->field('displaySitename'), $displaySitename ?? '', ['maxlength' => 255, 'placeholder' => t('Enter your site name')]); ?>
</div>

<?php
if (!empty($logoIcon) && $logoIcon > 0) {
    $logoIcon_o = File::getByID($logoIcon);
    if (!is_object($logoIcon_o)) {
        unset($logoIcon_o);
    }
}
?>

<div class="form-group">
    <?php echo $form->label('logoIcon', t('Site Icon')); ?>
    <?php echo $al->image('ccm-b-tallacmans_sitename-logoIcon-' . $identifier_getString, $view->field('logoIcon'), t('Choose Logo Image'), $logoIcon_o ?? null); ?>
    <p class="help-block">
        <?php echo t('Choose an icon for your site name. Leave width blank to preserve the uploaded image ratio.'); ?>
    </p>
</div>

<div class="form-group">
    <?php echo $form->label('iconWidth', t('Icon Width')); ?>
    <div class="input-group">
        <?php echo $form->number($view->field('iconWidth'), $iconWidth ?? 0, ['min' => 0, 'step' => 1, 'placeholder' => t('Auto')]); ?>
        <span class="input-group-text">px</span>
    </div>
    <p class="help-block">
        <?php echo t('Enter a pixel width to size the icon. Set to zero or leave blank to use the image’s natural width.'); ?>
    </p>
</div>

<div class="form-group">
    <?php echo $form->label('alignment', t('Icon Alignment')); ?>
    <?php echo $form->select($view->field('alignment'), $alignment_options, $alignment ?? 'image-left'); ?>
</div>
