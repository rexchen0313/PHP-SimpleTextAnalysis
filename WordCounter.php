<?php

class WordCounter
{
  protected $file_content = '';

  public function readFile(string $file_path)
  {
    if (file_exists($file_path)) {
      $content = file_get_contents($file_path);
      // $search = array(" ","　","\n","\r","\t");
      // $content = str_replace($search, "", $content);
      $content = preg_replace('/\s+/', '', $content); // 去除字串中所有半形空白符號(包括 \n、\r、\t 等)
      $content = str_replace('　', '', $content); // 去除字串中所有全形空白符號
      $this->file_content = $content;
    } else {
      echo '>> 文檔不存在，請重新確認!!!';
    }

    return $this;
  }

  public function run(int $str_length)
  {
    $content = $this->file_content;
    // 在 Ubuntu 14.04 出現 Uncaught Error: Call to undefined function mb_strlen()
    // 由於mb_strlen()是mbstring擴展的一部分，需要另外安裝 sudo apt install php7.x-mbstring 
    $content_length = mb_strlen($content, "utf-8"); // 取得載入文本的字串長度 
    $temp = [];
    $max = 0;
    $result = [];
    $punctuation_marks = ['!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ', ', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~', '；', '﹔', '︰', '﹕', '：', '，', '﹐', '、', '．', '﹒', '˙', '·', '。', '？', '！', '～', '‥', '‧', '′', '〃', '〝', '〞', '‵', '‘', '’', '『', '』', '「', '」', '“', '”', '…', '❞', '❝', '﹁', '﹂', '﹃', '﹄'];

    for ($i = 0; $i < $content_length - $str_length; $i++) {
      
      $str = mb_substr($content, $i, $str_length, "utf-8");

      if ((!isset($temp[$str])) && mb_strlen(str_replace($punctuation_marks, "", $str), "utf-8") > $str_length - 1) {
        $count = substr_count($content, $str);
        $temp[$str] = $count;

        if($count > $max) {
          $max = $count;
          $result = [];
          $result[$str] = $count;
        } elseif ($count === $max) {
          $result[$str] = $count;
        }
      }
    }
    return $result;
  }
}
