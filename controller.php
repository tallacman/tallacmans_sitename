<?php

namespace Concrete\Package\TallacmansSitename;

use Concrete\Core\Block\BlockType\BlockType;
use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Database;

defined('C5_EXECUTE') or exit('Access Denied.');

class Controller extends Package
{
    protected $pkgHandle = 'tallacmans_sitename';

    protected $appVersionRequired = '9.0.0';

    protected $pkgVersion = '2.0.0';

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
            if (! BlockType::getByHandle($btHandle)) {
                BlockType::installBlockType($btHandle, $pkg);
            }
        }
    }

    public function uninstall()
    {
        // needs use Concrete\Core\Support\Facade\Database;
        // cleanup package on uninstall
        $pkg = parent::uninstall();

        // drop database table
        $db = Database::connection();
        $db->executeQuery('drop table if exists btTallacmansSitename');
    }
}
