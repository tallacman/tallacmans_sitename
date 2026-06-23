<?php defined('C5_EXECUTE') or exit('Access Denied.'); ?>

<?php
$siteUrl = trim((string)DIR_REL, '/');
$siteUrl = $siteUrl === '' ? '/' : '/' . $siteUrl . '/';
$iconStyle = '';
if (!empty($iconWidth) && $iconWidth > 0) {
    $iconStyle = 'width:' . (int)$iconWidth . 'px; height:auto;';
}
?>

<div class="tallacmans-sitename-wrapper">
    <div class="tallacmans-sitename <?php echo h($alignment); ?>">
        <?php if ($logoIcon) { ?>
            <div class="tallacmans-sitename-icon">
                <a href="<?php echo h($siteUrl); ?>">
                    <img src="<?php echo h($logoIcon->getURL()); ?>"
                         alt="<?php echo h($logoIcon->getTitle() ?: t('Site icon')); ?>"
                         <?php if ($iconStyle) { echo 'style="' . $iconStyle . '"'; } ?> />
                </a>
            </div>
        <?php } ?>

        <?php if (!empty(trim((string)$displaySitename))) { ?>
            <div class="tallacmans-sitename-text">
                <a href="<?php echo h($siteUrl); ?>">
                    <?php echo h($displaySitename); ?>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
