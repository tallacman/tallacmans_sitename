<?php

namespace Concrete\Package\TallacmansSitename\Block\TallacmansSitename;

defined('C5_EXECUTE') or exit('Access Denied.');

use Concrete\Core\Block\BlockController;
use Concrete\Core\File\File;

//use Page;

class Controller extends BlockController
{
    protected $btTable = 'btTallacmansSitename';
    protected $btExportFileColumns = ['logoIcon'];
    protected $btInterfaceWidth = 420;
    protected $btInterfaceHeight = 520;
    protected $btDefaultSet = 'basic';
    protected $pkg = 'tallacmans_sitename';

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

        $this->set('iconWidth', (int)($this->iconWidth ?? 0));
    }

    public function add()
    {
        $this->addEdit();
        $this->set('displaySitename', '');
        $this->set('alignment', 'image-left');
        $this->set('iconWidth', 0);
    }

    public function edit()
    {
        $this->addEdit();
    }

    public function save($args)
    {
        $args['iconWidth'] = isset($args['iconWidth']) ? max(0, (int)$args['iconWidth']) : 0;

        if (!isset($args['alignment']) || !array_key_exists($args['alignment'], $this->getAlignmentOptions())) {
            $args['alignment'] = 'image-left';
        }

        return parent::save($args);
    }

    public function validate($data)
    {
        $e = $this->app->make('error');

        if (empty($data['logoIcon']) && empty(trim((string)($data['displaySitename'] ?? '')))) {
            $e->add(t('Please choose an icon or enter a site name.'));
        }

        if (isset($data['iconWidth']) && $data['iconWidth'] !== '' && (!is_numeric($data['iconWidth']) || (int)$data['iconWidth'] < 0)) {
            $e->add(t('Icon width must be a positive number or left blank.'));
        }

        return $e;
    }

    protected function addEdit()
    {
        $this->set('identifier_getString', uniqid('tallacmans_sitename_', true));
        $this->set('alignment_options', $this->getAlignmentOptions());
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
}
