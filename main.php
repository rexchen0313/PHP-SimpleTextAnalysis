<?php

require_once "WordCounter.php";
require_once "MultipleThreads.php";

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    die("此程式只支援在 Unix-like 的作業系統");
  } else {
    $multipleThreads = new MultipleThreads();
    $WordCounter = new WordCounter();
    $file_path = "阿Q正傳.txt";

    $multipleThreads
      ->setProcessService([$WordCounter, $file_path], function ($WordCounter, $file_path) {
        $result = $WordCounter->readFile($file_path)->run(2);
        print_r($result);
      })
      ->setProcessService([$WordCounter, $file_path], function ($WordCounter, $file_path) {
        $result = $WordCounter->readFile($file_path)->run(3);
        print_r($result);
      })
      ->setProcessService([$WordCounter, $file_path], function ($WordCounter, $file_path) {
        $result = $WordCounter->readFile($file_path)->run(4);
        print_r($result);
      })
      ->run();
  }

  
  