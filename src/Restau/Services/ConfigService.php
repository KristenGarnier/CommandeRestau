<?php

namespace Restau\Services;

use Symfony\Component\Yaml\Parser;

/**
 * Class ConfigService
 *
 * Allow to retrieve params for configurations purpose
 *
 * @package Api\Services
 */
class ConfigService
{

    private $_yaml;

    /**
     * @param Parser $yaml
     */
    public function __construct(Parser $yaml)
    {
        $this->_yaml = $yaml;
    }

    /**
     * Return the database configuration
     *
     * @return mixed
     */
    public function getDatabaseConfig()
    {
        $database = $this->_yaml->parse(file_get_contents("../app/config/config.yml"));
        return $database['database'];
    }

    /**
     * Return the debug config
     *
     * @return mixed
     */
    public function getDebugConfig()
    {
        $debug = $this->_yaml->parse(file_get_contents("../app/config/config.yml"));
        return $debug['debug'];
    }


}