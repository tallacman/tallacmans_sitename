<?php

declare(strict_types=1);

namespace Concrete\Package\TallacmansSitename;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Database;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends Package
{
    protected $pkgHandle = 'tallacmans_sitename';

    protected $appVersionRequired = '9.0.0';

    protected $pkgVersion = '2.3.0';

    public function getPackageName()
    {
        return t('Tallacmans Sitename');
    }

    public function getPackageDescription()
    {
        return t('Display a styled site name and logo with optional icon width and flexible alignment.');
    }

    public function install()
    {
        $pkg = parent::install();
        $btHandles = [
            'tallacmans_sitename',
        ];
        foreach ($btHandles as $btHandle) {
            if (!BlockType::getByHandle($btHandle)) {
                BlockType::installBlockType($btHandle, $pkg);
            }
        }
    }

    public function upgrade()
    {
        $pkg = parent::upgrade();

        $blockType = BlockType::getByHandle('tallacmans_sitename');
        if ($blockType) {
            $blockType->refresh();
        }

        return $pkg;
    }

    public function uninstall()
    {
        $pkg = parent::uninstall();

        $db = Database::connection();
        $db->executeQuery('drop table if exists btTallacmansSitename');

        return $pkg;
    }
}
