<?php

namespace Scope\Cli;

class Configuration
{
    const CONFIG_FILE = '.scope.json';

    /**
     * @var array
     */
    private $config;

    public function get($name, $default = null)
    {
        $config = $this->getConfig();
        if (!$config || !array_key_exists($name, $config)) {
            return $default;
        }

        return $config[$name];
    }

    public function set($name, $value)
    {
        $config = $this->getConfig();
        $config[$name] = $value;

        file_put_contents($this->getFile(), json_encode($config));
    }

    private function getConfig()
    {
        if ($this->config) {
            return $this->config;
        }

        $file = $this->getFile();
        if (!file_exists($file)) {
            return [];
        }

        return json_decode(file_get_contents($file), true);
    }

    private function getFile()
    {
        return $this->getHomeDir() . DIRECTORY_SEPARATOR . self::CONFIG_FILE;
    }

    private function getHomeDir()
    {
        // Cannot use $_SERVER superglobal since that's empty during UnitUnishTestCase
        // getenv('HOME') isn't set on Windows and generates a Notice.
        $home = getenv('HOME');
        if (!empty($home)) {
            // home should never end with a trailing slash.
            $home = rtrim($home, '/');
        } elseif (!empty($_SERVER['HOMEDRIVE']) && !empty($_SERVER['HOMEPATH'])) {
            // home on windows
            $home = $_SERVER['HOMEDRIVE'] . $_SERVER['HOMEPATH'];
            // If HOMEPATH is a root directory the path can end with a slash. Make sure
            // that doesn't happen.
            $home = rtrim($home, '\\/');
        }

        return empty($home) ? null : $home;
    }
}
