<?php

use Psr\Log\LogLevel;
use Core\Interfaces\SimpleLogger;
use Core\Logger\Adapters\LoggerRouteFile;
use Core\Logger\Adapters\LoggerRouteStd;
use Core\Interfaces\LoggerFactory;
use Core\Logger\LoggerFactoryGeneric;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class LoggerTest extends PHPUnit\Framework\TestCase
{

    private LoggerFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new LoggerFactoryGeneric();
    }

    public function testLoggerFile()
    {
        $this->makeLogDir();
        $logFile = $this->getLogFile('log.txt');
        $log = $this->factory->logFile($logFile);
        $log->info('info message');
        $log->critical('alert message');
        $log->emergency('emergency message');
        $logContent = file_get_contents($logFile);
        $this->assertTrue(str_contains($logContent, 'info message'));
        $this->assertTrue(str_contains($logContent, 'alert message'));
        $this->assertTrue(str_contains($logContent, 'emergency message'));
        $this->deleteLogFile($logFile);
    }

    public function testLoggerCustom()
    {
        $this->makeLogDir();
        $log = $this->factory->getLogger();

        $logfile1 = $this->getLogFile('log1.txt');
        $logfile2 = $this->getLogFile('log2.txt');

        $log->addBroadcast(new LoggerRouteFile(['filePath' => $logfile1]))
                ->addBroadcast(new LoggerRouteFile(['filePath' => $logfile2]));

        $log->alert('test alert');
        $log->error('test error');
        $content1 = file_get_contents($logfile1);
        $content2 = file_get_contents($logfile2);
        $this->assertTrue(str_contains($content1, 'test alert'));
        $this->assertTrue(str_contains($content1, 'test error'));
        $this->assertTrue(str_contains($content2, 'test alert'));
        $this->assertTrue(str_contains($content2, 'test error'));
        $this->deleteLogFile($logfile1);
        $this->deleteLogFile($logfile2);
        $this->deleteLogDir();
    }

    public function testLoggerNull()
    {
        $logger = $this->factory->logNull();
        $logger->alert("alert message");
        $logger->info("info message");
        $this->assertTrue($logger instanceof SimpleLogger);
    }

    public function testLogStd()
    {
        $loggerRouteStd = new LoggerRouteStd(['echo' => true]);
        $loggerRouteStd->setDateFormat('Y-m-d');
        $loggerRouteStd->setTemplate("{date} {level} {message} {context}");

        ob_start();
        $loggerRouteStd->log(LogLevel::INFO, 'This is an info message.');
        $output = ob_get_clean();
        
        $expected = date('Y-m-d') . ' info This is an info message.';
        $this->expectOutputString($expected);
        echo $output;
    }
    
    public function getLogFile(string $filename = 'log.txt')
    {
        $ds = DIRECTORY_SEPARATOR;
        $dir = $this->getLogDir();
        return $dir = $dir . $ds . $filename;
    }

    public function getLogDir(): string
    {
        $ds = DIRECTORY_SEPARATOR;
        return getcwd() . $ds . 'tests' . $ds . 'logs';
    }

    public function makeLogDir()
    {
        $dir = $this->getLogDir();
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
            return true;
        }
        return false;
    }

    public function deleteLogFile(string $logFile)
    {
        if (file_exists($logFile)) {
            unlink($logFile);
        }
    }

    public function deleteLogDir()
    {
        if (file_exists($this->getLogDir())) {
            rmdir($this->getLogDir());
        }
    }

}
