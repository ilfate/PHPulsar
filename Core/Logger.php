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
class Logger extends AbstractFactory
{

    const VARIABLES_OUTPUT = 'output';
    const VARIABLES_LOGGER = 'logger';
    /**
     * is Logger needed
     *
     * @var Boolean
     */
    protected $is_logger_enabled = true;

    protected $is_output_enabled = false;

    protected $is_file_logging_enabled = true;

    protected $log_file = 'CoreLog.log';
    protected $log_path = 'logs/';

    protected $is_day_logging = false;

    protected $is_log_sql = false;

    /**
     * Shows is Sql query logging is enabled
     * @var \Core\Interfaces\Logger
     */
    private $sqlLogger;

    /**
     * Could be 'logger' OR 'output'
     *
     * @var String
     */
    private $variable_logging = self::VARIABLES_LOGGER;

    private $variables_container;

    public function __construct()
    {
        $config           = Service::getConfig();
        $this->is_log_sql = $config->get('log_sql');
        $this->log_path   = $config->get('logs_path');
        if ($this->is_log_sql) {
            $this->sqlLogger = new Sql();
        } else {
            $this->sqlLogger = new SqlEmpty();
        }
    }

    /**
     * Drop data to display it in stream or store it to file
     *
     * @param mixed  $data
     * @param String $mode can be 'auto'  'file'  'output'
     * @param null   $file
     */
    public function dump($data, $mode = 'auto', $file = null)
    {
        if (
            Service::getRequest()->getExecutingMode() != Request::EXECUTE_MODE_CLI
            && ($mode != 'file' && Service::getConfig()->get('is_dev'))
        ) {
            $this->outputData($data);
        } else if ($mode == 'file' || (Service::getRequest()->getExecutingMode() == Request::EXECUTE_MODE_CLI && $mode != 'output')) {
            $this->saveToFile($data, $file);
        }
    }

    /**
     * just outputs data
     *
     * @param mixed $data
     */
    public function output($data)
    {
        $this->dump($data, 'output');
    }

    public function getDump()
    {
        return $this->variables_container;
    }

    public function setVariablesOutput()
    {
        $this->variable_logging = self::VARIABLES_OUTPUT;
    }

    public function setVariablesLogging()
    {
        $this->variable_logging = self::VARIABLES_LOGGER;
    }

    public function sql_addQuery($query)
    {
        $this->sqlLogger->addQuery($query);
    }

    public function sql_getLog()
    {
        return $this->sqlLogger->getLog();
    }

    public function sql_start($query)
    {
        $this->sqlLogger->start($query);
    }

    public function sql_finish()
    {
        $this->sqlLogger->finish();
    }

    public function time($function, $times = 1000)
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
        $this->dump('Execution time = ' . (microtime(true) - $time));
    }

    private function outputData($data, $force_out = false)
    {
        ob_start();
        if (is_array($data) || is_object($data)) {
            print_r($data);
        } else {
            var_dump($data);
        }
        $content = ob_get_clean();

        if ($this->variable_logging == self::VARIABLES_OUTPUT || $force_out) {
            echo $content;
        } else {
            $this->variables_container[] = $content;
        }
    }

    private function saveToFile($data, $file = null)
    {
        ob_start();
        $this->outputData($data, true);
        $content = ob_get_clean();

        if (!$file) {
            $file = $this->log_file;
        }
        $file = $this->log_path . $file;

        file_put_contents(
            ILFATE_PATH . $file,
            "\n-----------------------------" . date('d.m.Y H:i:s') . "-----------------------------\n" . $content . "\n",
            FILE_APPEND);
    }
}
