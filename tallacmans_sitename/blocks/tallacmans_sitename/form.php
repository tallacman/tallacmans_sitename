<?php

declare(strict_types=1);

use Concrete\Core\File\File;

defined('C5_EXECUTE') or die('Access Denied.');

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

<fieldset>
    <legend><?php echo t('Spacing'); ?></legend>

    <div class="form-group">
        <?php echo $form->label('spaceHorizontal', t('Horizontal Spacing')); ?>
        <div class="input-group">
            <?php echo $form->number($view->field('spaceHorizontal'), $spaceHorizontal ?? 6, ['min' => 0, 'step' => 1]); ?>
            <span class="input-group-text">px</span>
        </div>
        <p class="help-block">
            <?php echo t('Space between the icon and site name when placed left or right.'); ?>
        </p>
    </div>

    <div class="form-group">
        <?php echo $form->label('spaceVertical', t('Vertical Spacing')); ?>
        <div class="input-group">
            <?php echo $form->number($view->field('spaceVertical'), $spaceVertical ?? 4, ['min' => 0, 'step' => 1]); ?>
            <span class="input-group-text">px</span>
        </div>
        <p class="help-block">
            <?php echo t('Space between the icon and site name when placed top or bottom.'); ?>
        </p>
    </div>

    <div class="form-group">
        <?php echo $form->label('blockPaddingTop', t('Block Padding Top')); ?>
        <div class="input-group">
            <?php echo $form->number($view->field('blockPaddingTop'), $blockPaddingTop ?? 0, ['min' => 0, 'step' => 1]); ?>
            <span class="input-group-text">px</span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->label('blockPaddingBottom', t('Block Padding Bottom')); ?>
        <div class="input-group">
            <?php echo $form->number($view->field('blockPaddingBottom'), $blockPaddingBottom ?? 0, ['min' => 0, 'step' => 1]); ?>
            <span class="input-group-text">px</span>
        </div>
        <p class="help-block">
            <?php echo t('Adds space above or below the entire site name block.'); ?>
        </p>
    </div>
</fieldset>

<fieldset>
    <legend><?php echo t('Text Style'); ?></legend>

    <div class="form-group">
        <?php echo $form->label('fontWeight', t('Text Weight')); ?>
        <?php echo $form->select($view->field('fontWeight'), $fontWeight_options, $fontWeight ?? '600'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->label('fontSize', t('Text Size')); ?>
        <div class="input-group">
            <?php echo $form->number($view->field('fontSize'), $fontSize ?? 18, ['min' => 1, 'step' => 1]); ?>
            <span class="input-group-text">px</span>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->label('textColor', t('Text Color')); ?>
        <div class="input-group">
            <?php echo $form->text($view->field('textColor'), $textColor ?? '', ['maxlength' => 7, 'placeholder' => '#333333', 'class' => 'form-control tallacmans-sitename-color-input']); ?>
            <input type="color" class="form-control form-control-color tallacmans-sitename-color-picker" value="<?php echo h($textColor ?: '#333333'); ?>" aria-label="<?php echo t('Text Color'); ?>">
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->label('textHoverColor', t('Hover Color')); ?>
        <div class="input-group">
            <?php echo $form->text($view->field('textHoverColor'), $textHoverColor ?? '', ['maxlength' => 7, 'placeholder' => '#0066cc', 'class' => 'form-control tallacmans-sitename-color-input']); ?>
            <input type="color" class="form-control form-control-color tallacmans-sitename-color-picker" value="<?php echo h($textHoverColor ?: '#0066cc'); ?>" aria-label="<?php echo t('Hover Color'); ?>">
        </div>
        <p class="help-block">
            <?php echo t('Leave blank to keep the text color on hover.'); ?>
        </p>
    </div>
</fieldset>

<script>
(function () {
    document.querySelectorAll('.input-group').forEach(function (group) {
        var textInput = group.querySelector('.tallacmans-sitename-color-input');
        var colorInput = group.querySelector('.tallacmans-sitename-color-picker');
        if (!textInput || !colorInput) {
            return;
        }

        colorInput.addEventListener('input', function () {
            textInput.value = colorInput.value;
        });

        textInput.addEventListener('input', function () {
            if (/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(textInput.value)) {
                colorInput.value = textInput.value.length === 4
                    ? '#' + textInput.value[1] + textInput.value[1] + textInput.value[2] + textInput.value[2] + textInput.value[3] + textInput.value[3]
                    : textInput.value;
            }
        });
    });
})();
</script>
