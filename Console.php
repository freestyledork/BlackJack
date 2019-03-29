<?php

    /**
     * Class Console
     * @package TextAdventure
     *
     * Handles all the console inputs and outputs
     */
class Console
{

    /**
     * read and trim the console message
     *
     * @return string
     */
    public static function readLine() : string
    {
        $fp = fopen('php://stdin', 'rb');
        return trim(fgets($fp, 1024));
    }


    /**
     * print a message to console
     *
     * @param string $message
     */
    public static function printLine(string $message) : void
    {
        print($message . PHP_EOL);
    }


    /**
     * loops through the array printing all messages on a new line
     *
     * @param array $messages
     */
    public static function printMultiLine(array $messages) : void
    {
        foreach ($messages as $message){
            self::printLine($message);
        }
    }


    /**
     * attempt to clear the users terminal/console
     */
    public static function clearTerminal () {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            popen('cls', 'w');
        } else {
            exec('clear');
        }
    }

}
