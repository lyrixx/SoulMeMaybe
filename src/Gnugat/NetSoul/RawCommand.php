<?php

/*
 * This file is part of the SoulMeMaybe software.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the `/LICENSE.md`
 * file that was distributed with this source code.
 */

namespace Gnugat\NetSoul;

use Exception;

/**
 * The NetSoul protocol is based on commands, which simply are strings with the
 * following format:
 *
 *     command_name [parameter]...\n
 *
 * A command is composed of a name, between none and many parameters separated
 * by spaces and a UNIX line ending.
 *
 * RawCommand makes available the name and parameters of received commands, and
 * is aimed at being passed to the CommandFactory.
 */
class RawCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param string $command
     */
    public static function makeFromString($command)
    {
        if (false === strpos($command, PHP_EOL)) {
            throw new Exception(sprintf('Error: missing line ending in (%s)', $command));
        }

        $parsedCommand = trim($command);
        $commandParameters = explode(' ', $parsedCommand);

        if (empty($parsedCommand)) {
            throw new Exception('Error: empty string');
        }

        $rawCommand = new RawCommand();
        $rawCommand->name = array_shift($commandParameters);
        $rawCommand->parameters = $commandParameters;
        
        return $rawCommand;
    }
    
    private function __construct()
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
