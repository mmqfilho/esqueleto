<?php

/**
 * Class Erro
 */
class Erro
{
    /**
     * @param $msg
     * @param string $level
     * @return bool
     */
    public static function log($msg, $level='info')
    {
        try {
            $datefilename = date('Y-m-d');
            $file = DIR_LOGS . $datefilename . '.log';
            $levelStr = '';
            switch ($level) {
                case'info':
                    $levelStr = 'INFO';
                    break;

                case'warning':
                    $levelStr = 'WARNING';
                    break;

                case'error':
                    $levelStr = 'ERROR';
                    break;
            }
            $date = date('Y-m-d H:i:s');
            $msg = sprintf("[%s][%s]:%s%s", $date, $levelStr, $msg, PHP_EOL);
            file_put_contents($file, $msg, FILE_APPEND);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $erro
     */
    public static function display($erro)
    {
        if (!is_array($erro)) {
            $arrErro = array();
            $arrErro[] = $erro;
        }
        $_SESSION['errors'] = $arrErro;
    }

    /**
     * @param Exception $e
     */
    public static function trataErro(Exception $e)
    {
        $_SESSION['exception'] = $e;
        View::redirect('/erro', true);

    }
}
