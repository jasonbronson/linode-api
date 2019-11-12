<?php 
declare(strict_types=1);
namespace Logger;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

trait Logging {

    public $validator;
    public $logfile;

    public function intialize(bool $standardOutput = true, string $logname = "log", string $filename = "merchant.log"){
        
        $formatter = new LineFormatter(LineFormatter::SIMPLE_FORMAT, LineFormatter::SIMPLE_DATE);
        $formatter->includeStacktraces(true);
        
        $this->logger = new Logger($logname);  
        if(!$standardOutput){
            $this->logger->pushHandler(new StreamHandler(__DIR__.DIRECTORY_SEPARATOR.$filename, Logger::DEBUG));
        }else{
            $this->logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());
        }
        
    }
    
    public function log($message, $level = "DEBUG"): void{ 

        $this->intialize();

        $function = debug_backtrace()[1]['function'];
        if(is_array($message)){
            $message = json_encode($message);
        }
        $message = $function . " " . $message;
        switch($level){
            case "DEBUG":
                $this->logger->debug($message."\n");
            break;
            case "INFO":
                $this->logger->info($message."\n");
            break;
            case "ERROR":
                $this->logger->error($message."\n");
            break;
            default:
                return;
            break;
            
        }
    }

}