<?php

// CSVファイルのオープンとクローズ
// $fp = fopen("開きたいファイル", "モード"); // モード: r:読込、w:書込(ファイルの中身を空にしてから書込)、a:追記書込
// while ($data = fgets($fp)){
//     何かしら処理
// }
// fclose($fp);

// 社員情報CSVオープン
$fp = fopen(__DIR__ . "/input.csv", "r");

// ファイルを1行ずつ読込、終端まで繰り返し
$lineCount = 0;
$manCount = 0;
$womanCount = 0;
while ($data = fgetcsv($fp)){
    $lineCount++;
    // 1行目のヘッダーは飛ばす。
    if($lineCount === 1){
        continue;
    }
    var_dump($data);

    // 男性？
    if ($data[4] === "男性"){
        // 男性人数 = 男性人数 + 1
        $manCount++;
    } else {
        // 女性人数 = 女性人数 + 1
        $womanCount++;
    }
}
// 社員情報CSVクローズ
fclose($fp);

// debug
// echo "$manCount" . "\n", "$womanCount" . "\n";

// 出力ファイルオープン
$fpOut = fopen(__DIR__ . "/output.csv", "w");

// ヘッダー行 書込
$header = ["男性", "女性"];
fputcsv($fpOut, $header);

// 男性人数,女性人数 書込
$outputData = [$manCount, $womanCount];
fputcsv($fpOut, $outputData);

// 出力ファイル クローズ
fclose($fpOut);
?>
