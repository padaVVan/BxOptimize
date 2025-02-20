<?php

namespace Dumkaaa\BxOptimize\Install;

use Composer\Script\Event;

class Installer
{
    protected static $tools = [
        'gif' => 'gifsicle',
        'png' => 'optipng',
        'jpg' => 'jpegtran',
        'pngquant' => 'pngquant',
    ];

    protected static $extByPlatforms = [
        'linux' => '-linux',
        'win' => '.exe',
    ];

    /**
     * Скачивает бинарники и кладёт их в папку bin/.
     *
     * @param Event $event
     */
    public static function getBinaries(Event $event)
    {
        $dir = self::getRootPath() . '/bin';

        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $event->getIO()->write("<info>Setup binaries to $dir :</info>");

        foreach (self::$extByPlatforms as $ext) {
            foreach (self::$tools as $tool) {
                file_put_contents(
                    $dir . '/' . $tool . $ext,
                    fopen('https://github.com/nosilver4u/ewww-image-optimizer/raw/master/binaries/' . $tool . $ext, 'r')
                );
                chmod($dir . '/' . $tool . $ext, 0754);
                $event->getIO()->write($tool . $ext);
            }
        }

        $event->getIO()->write('<info>Setup binaries complete.</info>');
    }

    public static function getRootPath()
    {
        return dirname(dirname(__DIR__));
    }
}
