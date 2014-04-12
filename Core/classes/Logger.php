<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace Core;
use Core\Logger\Sql;
use Core\Logger\SqlEmpty;

/**
 * Description of CoreLogger
 *
 * @author ilfate
 */
class Logger
{

    const VARIABLES_OUTPUT = 'output';
    const VARIABLES_LOGGER = 'logger';
    /**
     * is Logger needed
     *
     * @var Boolean
     */
    protected static $is_logger_enabled = true;

    protected static $is_output_enabled = false;

    protected static $is_file_logging_enabled = true;

    protected static $log_file = 'CoreLog.log';
    protected static $log_path = '';

    protected static $is_day_logging = false;

    protected static $is_log_sql = false;

    /**
     * Shows is Sql query logging is enabled
     * @var \Core\Interfaces\Logger
     */
    private static $sqlLogger;

    /**
     * Could be 'logger' OR 'output'
     *
     * @var String
     */
    private static $variable_logging = self::VARIABLES_LOGGER;

    private static $variables_container;

    public static function __staticConstruct()
    {
        $config           = Service::getConfig();
        self::$is_log_sql = $config->get('log_sql');
        self::$log_path   = $config->get('logs_path');
        if (self::$is_log_sql) {
            self::$sqlLogger = new Sql();
        } else {
            self::$sqlLogger = new SqlEmpty();
        }
    }

    /**
     *
     * @param mixed  $data
     * @param String $mode can be 'auto'  'file'  'output'
     * @param null   $file
     */
    public static function dump($data, $mode = 'auto', $file = null)
    {
        if (
            Service::getRequest()->getExecutingMode() != Request::EXECUTE_MODE_CLI
            && ($mode != 'file' && Service::getConfig()->get('is_dev'))
        ) {
            self::outputData($data);
        } else if ($mode == 'file' || (Service::getRequest()->getExecutingMode() == Request::EXECUTE_MODE_CLI && $mode != 'output')) {
            self::saveToFile($data, $file);
        }
    }

    /**
     * just outputs data
     *
     * @param mixed $data
     */
    public static function output($data)
    {
        self::dump($data, 'output');
    }

    public static function getDump()
    {
        return self::$variables_container;
    }

    public static function setVariablesOutput()
    {
        self::$variable_logging = self::VARIABLES_OUTPUT;
    }

    public static function setVariablesLogging()
    {
        self::$variable_logging = self::VARIABLES_LOGGER;
    }

    public static function sql_addQuery($query)
    {
        self::$sqlLogger->addQuery($query);
    }

    public static function sql_getLog()
    {
        return self::$sqlLogger->getLog();
    }

    public static function sql_start($query)
    {
        self::$sqlLogger->start($query);
    }

    public static function sql_finish()
    {
        self::$sqlLogger->finish();
    }

    public static function time($function, $times = 1000)
    {
        if ($function instanceof \Closure) {
            $func = $function;
        } else {
            $func = function () use ($function) {
                eval($function);
            };
        }
        $time = microtime(true);
        for ($i = 0; $i < $times; $i++) {
            $func();
        }
        self::dump('Execution time = ' . (microtime(true) - $time));
    }

    private static function outputData($data, $force_out = false)
    {
        ob_start();
        if (is_array($data) || is_object($data)) {
            print_r($data);
        } else {
            var_dump($data);
        }
        $content = ob_get_clean();

        if (self::$variable_logging == self::VARIABLES_OUTPUT || $force_out) {
            echo $content;
        } else {
            self::$variables_container[] = $content;
        }
    }

    private static function saveToFile($data, $file = null)
    {
        ob_start();
        self::outputData($data, true);
        $content = ob_get_clean();

        if (!$file) {
            $file = self::$log_file;
        }
        $file = self::$log_path . $file;

        file_put_contents(
            $file,
            "\n-----------------------------" . date('d.m.Y H:i:s') . "-----------------------------\n" . $content . "\n",
            FILE_APPEND);
    }
}
