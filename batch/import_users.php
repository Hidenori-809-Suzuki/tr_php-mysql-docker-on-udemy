<?php
// データベース接続
$username = "udemy_user";
$password = "udemy_pass";
$hostname = "db";
$db = "udemy_db";

try {
    $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 社員情報CSVオープン
    $fp = fopen(__DIR__ . "/import_users.csv", "r");

    // トランザクション開始
    $pdo->beginTransaction();

    // ファイルを1行ずつ読込、終端まで繰り返し
    while ($data = fgetcsv($fp)){
        // var_dump($data);
        // 社員番号をキーに社員情報取得SQLの実行
        $sql = "SELECT COUNT(*) as count FROM users WHERE id = :id";
        $param = [":id" => $data[0]];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($param);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // debug
        // var_dump($data[0]);
        // var_dump($result);
        // SQLの結果件数は0件？
        if ($result["count"] === "0") {
            // 社員情報更新SQLの実行
            // var_dump($data[0]);
            // var_dump("登録");
            $sql = "INSERT INTO users (";
            $sql .= " id, ";
            $sql .= " name, ";
            $sql .= " name_kana, ";
            $sql .= " birthday, ";
            $sql .= " gender, ";
            $sql .= " organization, ";
            $sql .= " post, ";
            $sql .= " start_date, ";
            $sql .= " tel, ";
            $sql .= " mail_address, ";
            $sql .= " created, ";
            $sql .= " updated ";
            $sql .= ") VALUES (";
            $sql .= " :id, ";
            $sql .= " :name, ";
            $sql .= " :name_kana, ";
            $sql .= " :birthday, ";
            $sql .= " :gender, ";
            $sql .= " :organization, ";
            $sql .= " :post, ";
            $sql .= " :start_date, ";
            $sql .= " :tel, ";
            $sql .= " :mail_address, ";
            $sql .= " NOW(), "; // 作成日時
            $sql .= " NOW() "; // 更新日時
            $sql .= ")";
        } else {
            // var_dump($data[0]);
            // var_dump("更新");
            $sql = "UPDATE users ";
            $sql .= "SET name = :name, ";
            $sql .= " name_kana = :name_kana, ";
            $sql .= " birthday = :birthday, ";
            $sql .= " gender = :gender, ";
            $sql .= " organization = :organization, ";
            $sql .= " post = :post, ";
            $sql .= " start_date = :start_date, ";
            $sql .= " tel = :tel, ";
            $sql .= " mail_address = :mail_address, ";
            $sql .= " updated = NOW() "; // 更新日時
            $sql .= "WHERE id = :id ";
        }
        $param = array(
            "id" => $data[0],
            "name" => $data[1],
            "name_kana" => $data[2],
            "birthday" => $data[3],
            "gender" => $data[4],
            "organization" => $data[5],
            "post" => $data[6],
            "start_date" => $data[7],
            "tel" => $data[8],
            "mail_address" => $data[9],
        );
        $stmt = $pdo->prepare($sql);
        $stmt->execute($param);
        // 社員情報登録SQLの実行
    }

    // コミット
    $pdo->commit();

    // 社員情報CSVクローズ
    fclose($fp);
} catch (PDOException $e) {
    $pdo->rollback();
    echo "Error: " . $e->getMessage();
}
?>
