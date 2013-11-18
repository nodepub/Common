<?php

namespace NodePub\Common\Config;

use Symfony\Component\Yaml\Yaml;

/**
 * Loads and saves settings to a yaml file
 */
interface ConfigurationProviderInterface
{
    public function get($key, $default = null);

    public function getAll();

    public function update($key, $value);
}