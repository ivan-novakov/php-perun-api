<?php

namespace InoPerunClient;

use Zend\Console\Console;
use Zend\Console\Getopt;
use Zend\Console\ColorInterface;
use InoPerunApi\Client as PerunClient;
use InoPerunApi\Entity\Factory\GenericFactory;
require __DIR__ . '/../vendor/autoload.php';

try {
    $client = new Client();
} catch (\Exception $e) {
    printf("Error initializing client: %s\n", $e->getMessage());
    exit(10);
}

try {
    $client->run();
} catch (\Exception $e) {
    printf("Error running client: %s", $e->getMessage());
    exit(20);
}

// ------
class Client
{

    /**
     * @var Options
     */
    protected $options = null;

    /**
     * @var Console
     */
    protected $console = null;


    public function __construct(Options $options = null, Console $console = null)
    {
        if (null === $options) {
            $options = new Options();
        }
        $this->options = $options;
        
        if (null === $console) {
            $console = Console::getInstance();
        }
        $this->console = $console;
    }


    public function run()
    {
        try {
            $this->options->parse();
        } catch (\Exception $e) {
            $this->_handleException($e, false);
            $this->_showLine($this->options->getUsage());
            $this->_exit();
        }
        
        $configFile = $this->options->getConfigFile();
        if (!\file_exists($configFile) || !\is_readable($configFile)) {
            $this->_showError(sprintf("File '%s' cannot be found or not readable", $configFile));
        }
        $config = require $configFile;
        
        if (! is_array($config)) {
            $this->_showError(sprintf("Invalid config file '%s'", $configFile));
        }
        
        $this->_showInfo(sprintf("Loaded config file '%s' ...", $configFile));
        
        $perunClientFactory = new PerunClient\ClientFactory();
        $perunClient = $perunClientFactory->createClient($config);
        
        $managerName = $this->options->getManagerName();
        $functionName = $this->options->getFunctionName();
        $arguments = $this->options->getArguments();
        
        $this->_showInfo(sprintf("Calling %s->%s (%s)", $managerName, $functionName, http_build_query($arguments, null, ', ')));
        
        $response = $perunClient->sendRequest($managerName, $functionName, $arguments, true);
        if ($response->isError()) {
            $this->_showError(sprintf("Perun error [%s]: %s (%s)", $response->getErrorId(), $response->getErrorType(), $response->getErrorMessage()));
        }
        
        $data = $this->_processResultData($response->getPayload()
            ->getParams(), $this->options->getFilter());
        
        if ($this->options->getOption('entity')) {
            $entityFactory = new GenericFactory();
            $entity = $entityFactory->create($data);
            print_r($entity);
        } else {
            print_r($data);
        }
        
        $this->_showInfo('Result OK');
        $this->_exit(0);
    }


    protected function _processResultData(array $data, $filter)
    {
        if ($filter && is_array($filter) && ! empty($filter)) {
            $filteredData = array();
            if (isset($data['beanName'])) {
                $filteredData = $this->_processSingleResult($data, $filter);
            } else {
                foreach ($data as $record) {
                    $filteredData[] = $this->_processSingleResult($record, $filter);
                }
            }
            
            $data = $filteredData;
        }
        
        return $data;
    }


    protected function _processSingleResult(array $data, $filter)
    {
        $resultData = array();
        foreach ($filter as $attributeName) {
            if (isset($data[$attributeName])) {
                $resultData[$attributeName] = $data[$attributeName];
            }
        }
        
        return $resultData;
    }


    protected function _handleException(\Exception $e, $exit = true, $exitCode = 99)
    {
        $this->_showError($e->getMessage(), $exit, $exitCode);
    }


    protected function _showInfo($message)
    {
        $this->console->write('INFO: ', ColorInterface::CYAN);
        $this->_showLine($message);
    }


    protected function _showError($message, $exit = true, $exitCode = 99)
    {
        $this->console->write('ERROR: ', ColorInterface::LIGHT_RED);
        $this->_showLine($message);
        if ($exit) {
            $this->_exit($exitCode);
        }
    }


    protected function _showLine($line)
    {
        $this->console->writeLine($line);
    }


    protected function _exit($code = 99)
    {
        exit($code);
    }
}


class Options
{

    const OPT_CONFIG = 'config';

    const OPT_MANAGER = 'manager';

    const OPT_FUNCTION = 'function';

    const OPT_ARGS = 'args';

    const OPT_FILTER = 'filter';

    protected $consoleOptions = null;

    protected $managerName = null;

    protected $functionName = null;

    protected $arguments = array();

    protected $configFile = null;


    public function __construct(Getopt $opts = null)
    {
        if (null === $opts) {
            $opts = $this->_createGetopt();
        }
        
        $this->consoleOptions = $opts;
    }


    public function getConsoleGetopt()
    {
        return $this->consoleOptions;
    }


    public function getUsage()
    {
        return $this->consoleOptions->getUsageMessage();
    }


    public function getManagerName()
    {
        return $this->managerName;
    }


    public function getFunctionName()
    {
        return $this->functionName;
    }


    public function getArguments()
    {
        return $this->arguments;
    }


    public function getConfigFile()
    {
        return $this->configFile;
    }


    public function getOption($name)
    {
        return $this->consoleOptions->getOption($name);
    }


    public function getFilter()
    {
        $filter = $this->consoleOptions->getOption(self::OPT_FILTER);
        if ($filter && ! is_array($filter)) {
            $filter = array(
                $filter
            );
        }
        
        return $filter;
    }


    public function parse()
    {
        $configFile = $this->consoleOptions->getOption(self::OPT_CONFIG);
        if (! $configFile) {
            throw new \RuntimeException(sprintf("No config specified, missing options '%s'", self::OPT_CONFIG));
        }
        $this->configFile = $configFile;
        
        $managerName = $this->consoleOptions->getOption(self::OPT_MANAGER);
        if (! $managerName) {
            throw new \RuntimeException(sprintf("No manager specified, missing options '%s'", self::OPT_MANAGER));
        }
        $this->managerName = $managerName;
        
        $functionName = $this->consoleOptions->getOption(self::OPT_FUNCTION);
        if (! $functionName) {
            throw new \RuntimeException(sprintf("No function specified, missing options '%s'", self::OPT_FUNCTION));
        }
        $this->functionName = $functionName;
        
        $args = $this->consoleOptions->getOption(self::OPT_ARGS);
        if ($args) {
            $this->arguments = $this->_parseArguments($args);
        }
    }


    protected function _parseArguments($args)
    {
        $parsedArgs = array();
        
        if (! is_array($args)) {
            $args = array(
                $args
            );
        }
        
        foreach ($args as $argKeyValuePair) {
            $pair = explode('=', $argKeyValuePair);
            if (count($pair) != 2) {
                continue;
            }
            
            $key = trim($pair[0]);
            $value = $pair[1];
            
            $parsedArgs[$key] = $value;
        }
        
        return $parsedArgs;
    }


    protected function _createGetopt()
    {
        $opts = new Getopt(array(
            'config|c=s' => 'configuration file',
            'manager|m=s' => 'the remote manager to be used, such as "usersManager", "groupsManager" etc.',
            'function|f=s' => 'the function of the remote manager to be called',
            'args|a=s' => 'function arguments - key/value comma separated, for example: key1=value1,key2=value2, ...',
            'filter|F=s' => 'filter attributes',
            'entity|e' => 'return result as entity'
        // 'payload|p=s' => 'instead of passing arguments, it is possible to pass the whole request payload as a string'
                ));
        $opts->setOptions(array(
            Getopt::CONFIG_PARAMETER_SEPARATOR => ','
        ));
        
        return $opts;
    }
}


function _dump($value)
{
    error_log(print_r($value, true));
}
