<?php
require_once 'functions.php';
require_once 'config.php';

try {
  $pdo = new PDO(
    DSN,
    DB_USER,
    DB_PASS,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );

  $stmt = $pdo->query("SELECT ID, post_name FROM wp_posts WHERE post_type LIKE 'post'");
  $result = $stmt->fetchALL();

  updateCsvData($result);
} catch (PDOException $e) {
  echo '接続失敗: ' . $e->getMessage() . PHP_EOL;
  exit();
}