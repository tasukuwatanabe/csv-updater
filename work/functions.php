<?php
require_once 'config.php';

function updateCsvData($rows) {
  $permalink_ids = [];

  foreach ($rows as $row) {
    $permalink_ids[$row->post_name] = $row->ID;
  }

  if (!(file_exists(OLD_CSV_NAME) && $csv = fopen(OLD_CSV_NAME, 'r'))) {
    exit(OLD_CSV_NAME . 'が見つかりません。');
  }

  $updated_csv_data = [];

  while (($data = fgetcsv($csv))) {
    $redirect_from = $data[2];
    $redirect_to = $data[3];

    // リダイレクト元URLを記事IDと置換する処理
    $permalink_str = str_replace('/', '', $redirect_from);
    $redirect_from = "/${permalink_ids[$permalink_str]}/";

    // curlを叩いてリダイレクト先URLを確認する処理
    $redirect_to = getRedirectUrl($redirect_to);

    // $dataの情報を更新する
    $data = [ $data[0], $data[1], $redirect_from, $redirect_to ];

    // 更新後のCSV情報を配列に入れておく
    $updated_csv_data[] = implode(',', $data);
  }

  // $updated_csv_dataを元に、新しいCSVファイルを生成する
  createCsv($updated_csv_data);
}

function getRedirectUrl($url) {
  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_NOBODY => true
  ]);

  curl_exec($curl);

  $result = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);

  return $result;
}

function createCsv( $updated_csv_data ) {
  $fp = fopen(NEW_CSV_NAME, 'w');

  foreach($updated_csv_data as $data) {
    fwrite($fp, $data . "\n");
  }

  fclose($fp);

  echo NEW_CSV_NAME . 'が生成されたよ！';
}