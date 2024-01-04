<?php

/**
 * ログを出力する
 *
 * @param string $fileName 出力するログファイル名
 * @param string $message 出力するメッセージ
 * @return void 何も返さない場合はvoid
 */
function writeLog($fileName, $message) {
    $now = date("Y/m/d H:i:s");
    $log = "{$now} {$message}\n";

    $fp = fopen($fileName, "a");
    fwrite($fp, $log);
    fclose($fp);
}

?>
