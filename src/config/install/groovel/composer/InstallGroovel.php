<?php

namespace  Groovel\Cmsgroovel\config\install\groovel\composer;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use Monolog\Logger;

class InstallGroovel
{
    public static function postUpdate(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff
    }

    public static function postAutoloadDump(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        require $vendorDir . '/autoload.php';

        some_function_from_an_autoloaded_file();
    }

    public static function postPackageInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
       \Log::info("i am called");
    }

    public static function warmCache(Event $event)
    {
        // make cache toasty
    }
}