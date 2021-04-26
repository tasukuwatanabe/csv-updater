<?php
require_once 'config.php';

echo "①index.phpと同じ階層に「" . OLD_CSV_NAME . "」をセットしてください。<br>";
echo "②http://localhost:8562/update.php にアクセスすると処理が走ります。<br>";
echo "③「" . NEW_CSV_NAME . "」が生成されていれば成功です。";