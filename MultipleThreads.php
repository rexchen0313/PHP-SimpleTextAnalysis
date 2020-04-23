<?php
class MultipleThreads 
{
  protected $processes = [];

  public function  __construct()
  {
    if (strtoupper(php_sapi_name()) !== 'CLI') {
      die(">> 此程式只支援在 PHP-cli 環境下執行!!!");
    }
  }

  public function setProcessService(array $variables, Closure $callback)
  {
    $this->processes[] = [$variables, $callback];
    return $this;
  }

  public function run()
  {
    $pids = [];
    for ($i = 0; $i < count($this->processes); $i++) {
      $pid = pcntl_fork(); // pcntl_fork() 只在 Unix-like 的作業系統有支援
      if ($pid === -1) { // fork 失敗，返回-1
        die(">> 建立子程序發生錯誤，結束程式"); // 關閉程式
      } else if ($pid > 0) { // 父程序
        $pids[] = $pid; // 紀錄每個子程序的編號
        echo ">> 建立pid為{$pid}的子程序\n\n";
      } else { // 子程序
        break; // 跳出迴圈
      }
    }
    if ($pid) {
      foreach ($pids as $pid) { //要等每個子程序都關閉父程序才離開
        pcntl_waitpid($pid, $status);
        echo ">> 關閉pid為{$pid}的子程序\n";
      }
      echo ">> 父程序關閉，程式結束\n";
    } else {
      $variables = $this->processes[$i][0];
      $function = $this->processes[$i][1];
      if (is_callable($function)) {
        $function(...$variables);
      }
      exit();
    }
  }
}