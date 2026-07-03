<?php

declare(strict_types=1);

namespace Concrete\Package\TallacmansSitename\Block\TallacmansSitename;

use Concrete\Core\Block\BlockController;
use Concrete\Core\File\File;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends BlockController
{
    protected $btTable = 'btTallacmansSitename';

    protected $btExportFileColumns = ['logoIcon'];

    protected $btInterfaceWidth = 500;

    protected $btInterfaceHeight = 900;

    protected $btDefaultSet = 'basic';

    protected $pkg = 'tallacmans_sitename';

    public $textColor;

    public $textHoverColor;

    public $fontWeight;

    public $fontSize;

    public $spaceHorizontal;

    public $spaceVertical;

    public $blockPaddingTop;

    public $blockPaddingBottom;

    public function getBlockTypeDescription()
    {
        return t('Display a styled site name and logo with optional icon width and alignment.');
    }

    public function getBlockTypeName()
    {
        return t('Tallacmans Site Name');
    }

    public function view()
    {
        if ($this->logoIcon && ($file = File::getByID($this->logoIcon)) && is_object($file)) {
            $this->set('logoIcon', $file);
        } else {
            $this->set('logoIcon', false);
        }

        $this->set('iconWidth', (int) ($this->iconWidth ?? 0));
        $this->set('textColor', $this->sanitizeColor($this->textColor ?? ''));
        $this->set('textHoverColor', $this->sanitizeColor($this->textHoverColor ?? ''));
        $this->set('fontWeight', $this->sanitizeFontWeight($this->fontWeight ?? '600'));
        $this->set('fontSize', $this->sanitizeFontSize($this->fontSize ?? 18));
        $this->set('spaceHorizontal', $this->sanitizeSpacing($this->spaceHorizontal ?? 6));
        $this->set('spaceVertical', $this->sanitizeSpacing($this->spaceVertical ?? 4));
        $this->set('blockPaddingTop', $this->sanitizeSpacing($this->blockPaddingTop ?? 0));
        $this->set('blockPaddingBottom', $this->sanitizeSpacing($this->blockPaddingBottom ?? 0));
    }

    public function add()
    {
        $this->addEdit();
        $this->set('displaySitename', '');
        $this->set('alignment', 'image-left');
        $this->set('iconWidth', 0);
        $this->set('textColor', '');
        $this->set('textHoverColor', '');
        $this->set('fontWeight', '600');
        $this->set('fontSize', 18);
        $this->set('spaceHorizontal', 6);
        $this->set('spaceVertical', 4);
        $this->set('blockPaddingTop', 0);
        $this->set('blockPaddingBottom', 0);
    }

    public function edit()
    {
        $this->addEdit();
    }

    public function save($args)
    {
        $args['iconWidth'] = isset($args['iconWidth']) ? max(0, (int) $args['iconWidth']) : 0;

        if (!isset($args['alignment']) || !array_key_exists($args['alignment'], $this->getAlignmentOptions())) {
            $args['alignment'] = 'image-left';
        }

        $args['textColor'] = $this->sanitizeColor($args['textColor'] ?? '');
        $args['textHoverColor'] = $this->sanitizeColor($args['textHoverColor'] ?? '');
        $args['fontWeight'] = $this->sanitizeFontWeight($args['fontWeight'] ?? '600');
        $args['fontSize'] = $this->sanitizeFontSize($args['fontSize'] ?? 18);
        $args['spaceHorizontal'] = $this->sanitizeSpacing($args['spaceHorizontal'] ?? 6);
        $args['spaceVertical'] = $this->sanitizeSpacing($args['spaceVertical'] ?? 4);
        $args['blockPaddingTop'] = $this->sanitizeSpacing($args['blockPaddingTop'] ?? 0);
        $args['blockPaddingBottom'] = $this->sanitizeSpacing($args['blockPaddingBottom'] ?? 0);

        return parent::save($args);
    }

    public function validate($data)
    {
        $e = $this->app->make('error');

        if (empty($data['logoIcon']) && empty(trim((string) ($data['displaySitename'] ?? '')))) {
            $e->add(t('Please choose an icon or enter a site name.'));
        }

        if (isset($data['iconWidth']) && $data['iconWidth'] !== '' && (!is_numeric($data['iconWidth']) || (int) $data['iconWidth'] < 0)) {
            $e->add(t('Icon width must be a positive number or left blank.'));
        }

        if (!empty($data['textColor']) && !$this->isValidColor($data['textColor'])) {
            $e->add(t('Text color must be a valid hex color (for example, #333333).'));
        }

        if (!empty($data['textHoverColor']) && !$this->isValidColor($data['textHoverColor'])) {
            $e->add(t('Hover color must be a valid hex color (for example, #0066cc).'));
        }

        foreach (['spaceHorizontal', 'spaceVertical', 'blockPaddingTop', 'blockPaddingBottom'] as $field) {
            if (isset($data[$field]) && $data[$field] !== '' && (!is_numeric($data[$field]) || (int) $data[$field] < 0)) {
                $e->add(t('Spacing values must be zero or a positive number.'));
                break;
            }
        }

        if (isset($data['fontSize']) && $data['fontSize'] !== '' && (!is_numeric($data['fontSize']) || (int) $data['fontSize'] < 1)) {
            $e->add(t('Text size must be at least 1 pixel.'));
        }

        return $e;
    }

    protected function addEdit()
    {
        $this->set('identifier_getString', uniqid('tallacmans_sitename_', true));
        $this->set('alignment_options', $this->getAlignmentOptions());
        $this->set('fontWeight_options', $this->getFontWeightOptions());
    }

    protected function getAlignmentOptions()
    {
        return [
            'image-left' => t('Image Left'),
            'image-right' => t('Image Right'),
            'image-top' => t('Image Top'),
            'image-bottom' => t('Image Bottom'),
        ];
    }

    protected function getFontWeightOptions()
    {
        return [
            '300' => t('Light (300)'),
            '400' => t('Normal (400)'),
            '500' => t('Medium (500)'),
            '600' => t('Semi Bold (600)'),
            '700' => t('Bold (700)'),
        ];
    }

    protected function sanitizeColor($color)
    {
        $color = trim((string) $color);

        if ($color === '') {
            return '';
        }

        if ($color[0] !== '#') {
            $color = '#' . $color;
        }

        return $this->isValidColor($color) ? strtolower($color) : '';
    }

    protected function isValidColor($color)
    {
        return (bool) preg_match('/^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/', (string) $color);
    }

    protected function sanitizeFontWeight($fontWeight)
    {
        $fontWeight = (string) $fontWeight;

        return array_key_exists($fontWeight, $this->getFontWeightOptions()) ? $fontWeight : '600';
    }

    protected function sanitizeFontSize($fontSize)
    {
        $fontSize = (int) $fontSize;

        return $fontSize > 0 ? $fontSize : 18;
    }

    protected function sanitizeSpacing($spacing)
    {
        if ($spacing === '' || $spacing === null) {
            return 0;
        }

        return max(0, (int) $spacing);
    }
}
