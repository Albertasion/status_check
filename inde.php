<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 0);
require 'phpquery.php';
function format ($expre) {
    echo "<pre>";
    print_r($expre);
    echo "</pre>";
  }

function request ($url) {
  $ch = curl_init();  
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $output = curl_exec($ch);
  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // получение кода состояния HTTP
return $output;
}

 $servername = "localhost";
  $username = "user";
  $password = "user";
  $dbname = "parser_strum";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

  
//   $document = phpQuery::newDocument($output);
//   $pagination_links = pq('a.no_underline');
//   foreach ($pagination_links as $key=>$link) {
//     $pq1 =pq($link)->text();
//     $last_page[$key] = $pq1;
//   }

// $trash_page = array_pop($last_page);
// $last_page_url = end($last_page);
//   for ($n = $last_page_url; $n > 0; $n--) {
//           $full_url = 'https://strument.com.ua/category/zapchasti-al-ko/' . 'page' . $n;
//           $sql = "INSERT INTO pagination_links (id, pagin_links) VALUES (NULL, '$full_url')";
//             if ($conn->query($sql) === TRUE) {
//               echo "New record created successfully";
//           } else {
//               echo "Error: " . $sql . "<br>" . $conn->error;
//           }   
//       }


// отримаання файлив сторинок
//   $sql = "SELECT * FROM pagination_links";
// $result = $conn->query($sql);
// while ($row = $result->fetch_assoc()){
//     $row_cnt = $result->num_rows;
// $page_links_pagin = ($row['pagin_links']);
// $page_link_array[] = $page_links_pagin;
// }
// foreach ($page_link_array as $key=>$page_link) {
//   // if ($page_link == 'https://strument.com.ua/category/zapchasti-al-ko/page1610') break; 
// $responce = request($page_link);
// file_put_contents('/Users/albertas/pages/page_'.$key.'.html', $responce);
// }



//зчитувааня файлыв и додавання в таблицю всых товарив
// $dir_files_cache_pages = '/Users/albertas/pages/';
// $files_in_directory = scandir($dir_files_cache_pages, SCANDIR_SORT_NONE);
// foreach ($files_in_directory as $files) {
//   if ($files[0]!=='.' && $files[1]!=='.') {
//     $doc = file_get_contents($dir_files_cache_pages.'/'.$files);
//   $document = phpQuery::newDocument($doc);
//   $all_links_product = $document->find('.products_wrp')->find('.product_brief_table')->find('a.pb_product_name');
//   foreach ($all_links_product as $links) {
//     $pqlinks_product = pq($links)->attr('href');
//     $full_links_product = 'https://strument.com.ua' . $pqlinks_product;
//     $sql_product = "INSERT INTO products (id, product_links) VALUES (NULL, '$full_links_product')";
//                 if ($conn->query($sql_product) === TRUE) {
//                   echo "New record created successfully";
//               } else {
//                   echo "Error: " . $sql_product . "<br>" . $conn->error;
//               }   
//          }
//   }
//   unset($document);
//   phpQuery::unloadDocuments();
// }





//отримання файлыв товарыв
// $sql = "SELECT * FROM products";
// $result = $conn->query($sql);
//   while ($row = $result->fetch_assoc()){
//     $product_link = ($row['product_links']);
//     $product_link_array[] = $product_link;
//   }
//   foreach ($product_link_array as $key=>$product_link) {
//     $responce_product = request($product_link);
//     file_put_contents('/Users/albertas/products/product_'.$key.'.html', $responce_product);
//     }


//  зчитвання файлыв товарыв добавлення посилань на картинки 
// $dir_files_cache_pages_products = '/Users/albertas/products/';
// $files_in_directory_products = scandir($dir_files_cache_pages_products);
// foreach ($files_in_directory_products as $files) {
//   if ($files[0]!=='.' && $files[1]!=='.') {
//     $doc_product = file_get_contents($dir_files_cache_pages_products.'/'.$files);
//   $document_product = phpQuery::newDocument($doc_product);
// $sku = pq('.product_code')->text();
// $pattern = "/для заказа: (.*) \/ Артикул/";
// $preg = preg_match($pattern, $sku, $matches);
// $sku = $matches[1];
// $picture = pq('#img-current_picture')->attr('data-src');
//  $pattern_picture = "/data:image\/png/";
//  $preg_picture = preg_match($pattern_picture, $picture, $matches);
//  echo $preg_picture. '<br>';
//  if ($preg_picture==1) continue;
// $picture = 'https://strument.com.ua'. $picture; 
// echo $sku.'     '.$picture.'<br>';
// $sql_picture = "INSERT INTO picture (id, href, product_id) VALUES (NULL, '$picture', '$sku')";
// $conn->query($sql_picture); 
//   }
//   unset($document_product);
//   phpQuery::unloadDocuments();
// }

function request_status($url) {
  $ch = curl_init();  
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $output = curl_exec($ch);
  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // получение кода состояния HTTP
return $statusCode;
}



//отримання посилань картинок ы перевырка доступносты
$sql = "SELECT * FROM picture";
$result = $conn->query($sql);
  while ($row = $result->fetch_assoc()){
    $picture_link = ($row['href']);
    $sku = ($row['product_id']);
    $status = request_status($picture_link);
    echo $picture_link.'----'.$sku.'-'.$status.'<br>';
    // $picture_link_array[] = $picture_link;

    $sql_status = "INSERT INTO status_links (id, sku, status) VALUES (NULL, '$sku', '$status')";
    $conn->query($sql_status); 
  }
  
