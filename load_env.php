<?php
// Render 環境では `getenv()` を使うので、.env の読み込みは不要
if (!getenv('RENDER')) { 
    if (file_exists(__DIR__ . '/.env')) {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue; // コメント行を無視
            putenv($line);
        }
    }
} else {
    $secret_path = "/etc/secrets/";

    $env_vars = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
    
    foreach ($env_vars as $var) {
        if (file_exists($secret_path . $var)) {
            putenv("$var=" . trim(file_get_contents($secret_path . $var)));
        }
    }

}
// デバッグ用（環境変数の取得状況をログ出力）
error_log("DB_HOST: " . getenv('DB_HOST'));
error_log("DB_PORT: " . getenv('DB_PORT'));
error_log("DB_NAME: " . getenv('DB_NAME'));
error_log("DB_USER: " . getenv('DB_USER'));
error_log("DB_PASSWORD: " . getenv('DB_PASSWORD'));
?>