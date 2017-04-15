<?php

namespace console\components;

/**
 * Description of Curl
 *
 * @author Administrator
 */
class Curl {

    protected $headers = array();
    protected $ch=false;
    protected $errno;
    protected $errmsg;
    protected $content;
    protected $info;
    protected $_cookie;
    protected $curlopt_header=0;
    
    public function open($url) {
        $this->ch = curl_init($url);
        return $this->ch;
    }

    function close() {
        curl_close($this->ch);
    }

    public function setCookie($cookie) {
        $this->_cookie = $cookie;
    }

    function addHeader($key, $val) {
        $this->headers[] = $key . ":" . $val;
    }

    function setHeaders(array $headers) {
        foreach ($headers as $k => $v) {
            $this->addHeader($k, $v);
        }
    }

    function getContent() {
        return $this->content;
    }

    function getInfo() {
        return $this->info;
    }

    function getErrNo() {
        return $this->errno;
    }

    function getErrMsg() {
        return $this->errmsg;
    }
    
    public function returnHeader($bool){
        $this->curlopt_header = $bool;
    }

    function get() {
        if(!$this->ch){
            throw new \Exception("curl is not open!");
        }
        $options = array(
            CURLOPT_HEADER => $this->curlopt_header,
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
                // CURLOPT_SSL_VERIFYPEER => TRUE,    
                // CURLOPT_SSL_VERIFYHOST => 2,        // 检查证书中是否设置域名,0不验证
                // CURLOPT_SSL_CIPHER_LIST=> 'TLSv1',
                // CURLOPT_CAINFO         => getcwd().'/cacert.pem',
                 CURLOPT_COOKIEJAR      => $this->_cookie,
        );
        if (!empty($this->headers)) {
            $options[CURLOPT_HTTPHEADER] = $this->headers;
        }

        curl_setopt_array($this->ch, $options);
        if (!$this->content = curl_exec($this->ch)) {
            $this->err = curl_errno($this->ch);
            $this->errmsg = curl_error($this->ch);
            return false;
        }
        $this->info = curl_getinfo($this->ch);
        return true;
    }

    function setOpts(array $options) {
        curl_setopt_array($this->ch, $options);
    }

    function gets() {
        $options = array(
            CURLOPT_HEADER => $this->curlopt_header,
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "spider", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => TRUE,
            CURLOPT_SSL_VERIFYHOST => 2, // 检查证书中是否设置域名,0不验证
            // CURLOPT_SSL_CIPHER_LIST=> 'TLSv1',
            CURLOPT_CAINFO => getcwd() . '/cacert.pem',
            CURLOPT_COOKIEJAR => $this->_cookie,
        );
        if (!empty($this->headers)) {
            $options[CURLOPT_HTTPHEADER] = $this->headers;
        }

        $this->setOpts($options);

        if (!$this->content = curl_exec($this->ch)) {
            $this->err = curl_errno($this->ch);
            $this->errmsg = curl_error($this->ch);
            return false;
        }
        $this->info = curl_getinfo($this->ch);
        return true;
    }

    function setOpt($opt, $val) {
        curl_setopt($this->ch, $opt, $val);
    }

    function getHandler() {
        return $this->ch;
    }

    function post($data = '', $ssl = FALSE, $cainfo = NULL) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => $this->curlopt_header, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "gizp,deflate", // handle all encodings
            CURLOPT_USERAGENT => "Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/48.0.2564.23 Mobile Safari/537.36", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 5, // timeout on connect
            CURLOPT_TIMEOUT => 5, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_COOKIEFILE => $this->_cookie,
            CURLOPT_COOKIEJAR => $this->_cookie,
        );
        
        if ($ssl) {
            if ($cainfo) {
                $options[CURLOPT_SSL_VERIFYPEER] = TRUE;
                $options[CURLOPT_SSL_VERIFYHOST] = 2;
                $options[CURLOPT_CAINFO] = $cainfo;
            } else {
                $options[CURLOPT_SSL_VERIFYPEER] = FALSE;
                $options[CURLOPT_SSL_VERIFYHOST] = 0;
            }
        }

        if (!empty($this->headers)) {
            $options[CURLOPT_HTTPHEADER] = $this->headers;
        }

        curl_setopt_array($this->ch, $options);
        if (!$this->content = curl_exec($this->ch)) {
            $this->err = curl_errno($this->ch);
            $this->errmsg = curl_error($this->ch);
            return false;
        }
        $this->info = curl_getinfo($this->ch);
        return true;
    }

}
