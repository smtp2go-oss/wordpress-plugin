<?php

namespace SMTP2GOWPPlugin\Composer;

use SMTP2GOWPPlugin\Composer\Semver\VersionParser;
class InstalledVersions
{
    private static $installed = array('root' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'e0be9b12ec307dec7beea9ec173222674a42b079', 'name' => '__root__'), 'versions' => array('__root__' => array('pretty_version' => 'dev-master', 'version' => 'dev-master', 'aliases' => array(), 'reference' => 'e0be9b12ec307dec7beea9ec173222674a42b079'), 'composer/package-versions-deprecated' => array('pretty_version' => '1.11.99.2', 'version' => '1.11.99.2', 'aliases' => array(), 'reference' => 'c6522afe5540d5fc46675043d3ed5a45a740b27c'), 'guzzlehttp/guzzle' => array('pretty_version' => '7.3.0', 'version' => '7.3.0.0', 'aliases' => array(), 'reference' => '7008573787b430c1c1f650e3722d9bba59967628'), 'guzzlehttp/promises' => array('pretty_version' => '1.4.1', 'version' => '1.4.1.0', 'aliases' => array(), 'reference' => '8e7d04f1f6450fef59366c399cfad4b9383aa30d'), 'guzzlehttp/psr7' => array('pretty_version' => '2.0.0', 'version' => '2.0.0.0', 'aliases' => array(), 'reference' => '1dc8d9cba3897165e16d12bb13d813afb1eb3fe7'), 'humbug/php-scoper' => array('pretty_version' => '0.15.0', 'version' => '0.15.0.0', 'aliases' => array(), 'reference' => '98c92f2ec5e12756d59ce04dfad34f9fce6c19c3', 'replaced' => array(0 => '0.15.0')), 'jetbrains/phpstorm-stubs' => array('pretty_version' => 'v2020.3', 'version' => '2020.3.0.0', 'aliases' => array(), 'reference' => 'daf8849db40acded37b13231a291c7536922955b'), 'nikic/php-parser' => array('pretty_version' => 'v4.12.0', 'version' => '4.12.0.0', 'aliases' => array(), 'reference' => '6608f01670c3cc5079e18c1dab1104e002579143'), 'ocramius/package-versions' => array('replaced' => array(0 => '1.11.99')), 'psr/container' => array('pretty_version' => '1.1.1', 'version' => '1.1.1.0', 'aliases' => array(), 'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf'), 'psr/http-client' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '2dfb5f6c5eff0e91e20e913f8c5452ed95b86621'), 'psr/http-client-implementation' => array('provided' => array(0 => '1.0')), 'psr/http-factory' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => '12ac7fcd07e5b077433f5f2bee95b3a771bf61be'), 'psr/http-factory-implementation' => array('provided' => array(0 => '1.0')), 'psr/http-message' => array('pretty_version' => '1.0.1', 'version' => '1.0.1.0', 'aliases' => array(), 'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363'), 'psr/http-message-implementation' => array('provided' => array(0 => '1.0')), 'psr/log-implementation' => array('provided' => array(0 => '1.0|2.0')), 'ralouphie/getallheaders' => array('pretty_version' => '3.0.3', 'version' => '3.0.3.0', 'aliases' => array(), 'reference' => '120b605dfeb996808c31b6477290a714d356e822'), 'smtp2go-oss/smtp2go-php' => array('pretty_version' => '1.0.1beta', 'version' => '1.0.1.0-beta', 'aliases' => array(), 'reference' => '71748df834ed3b2242cac1d607963d33506f8853'), 'symfony/console' => array('pretty_version' => 'v4.4.29', 'version' => '4.4.29.0', 'aliases' => array(), 'reference' => '8baf0bbcfddfde7d7225ae8e04705cfd1081cd7b'), 'symfony/filesystem' => array('pretty_version' => 'v4.4.27', 'version' => '4.4.27.0', 'aliases' => array(), 'reference' => '517fb795794faf29086a77d99eb8f35e457837a7'), 'symfony/finder' => array('pretty_version' => 'v4.4.27', 'version' => '4.4.27.0', 'aliases' => array(), 'reference' => '42414d7ac96fc2880a783b872185789dea0d4262'), 'symfony/polyfill-ctype' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => '46cd95797e9df938fdd2b03693b5fca5e64b01ce'), 'symfony/polyfill-mbstring' => array('pretty_version' => 'v1.23.1', 'version' => '1.23.1.0', 'aliases' => array(), 'reference' => '9174a3d80210dca8daa7f31fec659150bbeabfc6'), 'symfony/polyfill-php73' => array('pretty_version' => 'v1.23.0', 'version' => '1.23.0.0', 'aliases' => array(), 'reference' => 'fba8933c384d6476ab14fb7b8526e5287ca7e010'), 'symfony/polyfill-php80' => array('pretty_version' => 'v1.23.1', 'version' => '1.23.1.0', 'aliases' => array(), 'reference' => '1100343ed1a92e3a38f9ae122fc0eb21602547be'), 'symfony/service-contracts' => array('pretty_version' => 'v2.4.0', 'version' => '2.4.0.0', 'aliases' => array(), 'reference' => 'f040a30e04b57fbcc9c6cbcf4dbaa96bd318b9bb')));
    public static function getInstalledPackages()
    {
        return \array_keys(self::$installed['versions']);
    }
    public static function isInstalled($packageName)
    {
        return isset(self::$installed['versions'][$packageName]);
    }
    public static function satisfies(VersionParser $parser, $packageName, $constraint)
    {
        $constraint = $parser->parseConstraints($constraint);
        $provided = $parser->parseConstraints(self::getVersionRanges($packageName));
        return $provided->matches($constraint);
    }
    public static function getVersionRanges($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        $ranges = array();
        if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            $ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
        }
        if (\array_key_exists('aliases', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
        }
        if (\array_key_exists('replaced', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
        }
        if (\array_key_exists('provided', self::$installed['versions'][$packageName])) {
            $ranges = \array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
        }
        return \implode(' || ', $ranges);
    }
    public static function getVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['version'];
    }
    public static function getPrettyVersion($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['pretty_version'];
    }
    public static function getReference($packageName)
    {
        if (!isset(self::$installed['versions'][$packageName])) {
            throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
        }
        if (!isset(self::$installed['versions'][$packageName]['reference'])) {
            return null;
        }
        return self::$installed['versions'][$packageName]['reference'];
    }
    public static function getRootPackage()
    {
        return self::$installed['root'];
    }
    public static function getRawData()
    {
        return self::$installed;
    }
    public static function reload($data)
    {
        self::$installed = $data;
    }
}
