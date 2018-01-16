<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logger {

    private $log_file = "/application/logs/xml.log";
    private $fp = null;

    public function logOpen() {
        $this->fp = fopen(getcwd() . $this->log_file, 'a');
    }

    public function logWrite($strMessage, $transacao) {
        if (!$this->fp)
            $this->logOpen();

        $path = $_SERVER["REQUEST_URI"];
        $data = date("Y-m-d H:i:s:u (T)");

        $log = "***********************************************" . "\n";
        $log .= $data . "\n";
        $log .= "DO ARQUIVO: " . $path . "\n\t";
        $log .= "OPERAÇÃO: " . $transacao . "\n\t";
        $log .= $strMessage . "\n\n";

        fwrite($this->fp, $log);
    }

}

?>