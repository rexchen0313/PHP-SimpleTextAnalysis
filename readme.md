# PHP Simple Text Analysis
題目: 使用 PHP 找出 阿Q正傳 中出現最多次的 二字詞、三字詞、四字詞。

採用 PHP multiple threads 方式 (使用 pcntl_fork( )，只在 Unix-like 的作業系統有支援)
## 筆記
### 請使用 PHP-cli 執行 : 
> PHP手册:  
> Process Control should not be enabled within a webserver environment and unexpected results may happen if any Process Control functions are used within a webserver environment.

### 在 Ubuntu 14.04 出現 Uncaught Error: Call to undefined function mb_strlen()

> 由於 mb_strlen() 是屬於 mbstring 擴展的一部分，在 Ubuntu 14.04 需要另外安裝
```
sudo apt install php7.x-mbstring
```