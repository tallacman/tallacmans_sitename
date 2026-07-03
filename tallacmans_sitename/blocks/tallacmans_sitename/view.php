<?php

declare(strict_types=1);

defined('C5_EXECUTE') or die('Access Denied.');

$siteUrl = trim((string) DIR_REL, '/');
$siteUrl = $siteUrl === '' ? '/' : '/' . $siteUrl . '/';
$blockScopeId = 'tallacmans-sitename-' . (int) $bID;
$iconStyle = '';
if (!empty($iconWidth) && $iconWidth > 0) {
    $iconStyle = 'width:' . (int) $iconWidth . 'px; height:auto;';
}

$flexStyle = [
    'row-gap:' . (int) ($spaceVertical ?? 4) . 'px',
    'column-gap:' . (int) ($spaceHorizontal ?? 6) . 'px',
];
$flexStyleAttr = ' style="' . implode(';', $flexStyle) . '"';

$wrapperStyle = [
    'padding-top:' . (int) ($blockPaddingTop ?? 0) . 'px',
    'padding-bottom:' . (int) ($blockPaddingBottom ?? 0) . 'px',
];
if (!empty($textColor)) {
    $wrapperStyle[] = '--sitename-text-color:' . $textColor;
}
if (!empty($textHoverColor)) {
    $wrapperStyle[] = '--sitename-text-hover-color:' . $textHoverColor;
}
if (!empty($fontSize)) {
    $wrapperStyle[] = '--sitename-font-size:' . (int) $fontSize . 'px';
}
$wrapperStyleAttr = ' style="' . implode(';', $wrapperStyle) . '"';

$linkStyle = [];
if (!empty($fontWeight)) {
    $linkStyle[] = 'font-weight:' . (int) $fontWeight;
}
$linkStyleAttr = $linkStyle ? ' style="' . implode(';', $linkStyle) . '"' : '';
?>

<style>
#<?php echo h($blockScopeId); ?> a {
    padding: 0 !important;
    margin: 0;
}
#<?php echo h($blockScopeId); ?> .tallacmans-sitename-text a {
    font-size: <?php echo (int) ($fontSize ?? 18); ?>px !important;
}
<?php if (!empty($textColor)) { ?>
#<?php echo h($blockScopeId); ?> .tallacmans-sitename-text a {
    color: <?php echo h($textColor); ?> !important;
}
<?php } ?>
<?php if (!empty($textHoverColor)) { ?>
#<?php echo h($blockScopeId); ?> .tallacmans-sitename-text a:hover,
#<?php echo h($blockScopeId); ?> .tallacmans-sitename-text a:focus {
    color: <?php echo h($textHoverColor); ?> !important;
}
<?php } ?>
</style>

<div class="tallacmans-sitename-wrapper" id="<?php echo h($blockScopeId); ?>"<?php echo $wrapperStyleAttr; ?>>
    <div class="tallacmans-sitename align-<?php echo h($alignment); ?>"<?php echo $flexStyleAttr; ?>>
        <?php if ($logoIcon) { ?>
            <div class="tallacmans-sitename-icon">
                <a href="<?php echo h($siteUrl); ?>">
                    <img src="<?php echo h($logoIcon->getURL()); ?>"
                         alt="<?php echo h($logoIcon->getTitle() ?: t('Site icon')); ?>"
                         <?php if ($iconStyle) { echo 'style="' . $iconStyle . '"'; } ?> />
                </a>
            </div>
        <?php } ?>

        <?php if (!empty(trim((string) $displaySitename))) { ?>
            <div class="tallacmans-sitename-text">
                <a href="<?php echo h($siteUrl); ?>"<?php echo $linkStyleAttr; ?>>
                    <?php echo h($displaySitename); ?>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
