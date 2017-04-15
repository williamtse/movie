<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=$this->title?></title>
<meta name="keywords" content="">
<meta name="description" content="">
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/nprogress.css">
<link rel="stylesheet" type="text/css" href="/css/style.css">
<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
<link rel="apple-touch-icon-precomposed" href="/images/icon.png">
<link rel="shortcut icon" href="/favicon.ico">
<script src="/js/jquery-2.1.4.min.js"></script>
<script src="/js/nprogress.js"></script>
<script src="/js/jquery.lazyload.min.js"></script>
<!--[if gte IE 9]>
  <script src="/js/jquery-1.11.1.min.js" type="text/javascript"></script>
  <script src="/js/html5shiv.min.js" type="text/javascript"></script>
  <script src="/js/respond.min.js" type="text/javascript"></script>
  <script src="/js/selectivizr-min.js" type="text/javascript"></script>
<![endif]-->
<!--[if lt IE 9]>
  <script>window.location.href='upgrade-browser.html';</script>
<![endif]-->
</head>
<body class="user-select">
<header class="header">
<nav class="navbar navbar-default" id="navbar">
<div class="container">
  <div class="header-topbar hidden-xs link-border">
    <ul class="site-nav topmenu">
      <li><a href="#" >标签云</a></li>
        <li><a href="#" rel="nofollow" >读者墙</a></li>
        <li><a href="#" title="RSS订阅" >
            <i class="fa fa-rss">
            </i> RSS订阅
        </a></li>
    </ul>
             勤记录 懂分享</div>
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#header-navbar" aria-expanded="false">
        <span class="sr-only"></span> <span class="icon-bar"></span>
        <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <h1 class="logo hvr-bounce-in"><a href="/" title="电影天堂">
            <img src="/logo.jpg" alt="电影天堂" height="50px"></a>
    </h1>
  </div>
  <div class="collapse navbar-collapse" id="header-navbar">
    <form class="navbar-form visible-xs" action="/Search" method="post">
      <div class="input-group">
        <input type="text" name="keyword" class="form-control" placeholder="请输入关键字" maxlength="20" autocomplete="off">
        <span class="input-group-btn">
        <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
        </span> </div>
    </form>
    <ul class="nav navbar-nav navbar-right">
      <li><a data-cont="" title="" href="/">首页</a></li>
      <li><a data-cont="" title="列表页" href="/movie/index">电影下载</a></li>
      <li><a data-cont="" title="详细页" href="/meiju/index">美剧下载</a></li>
    </ul>
  </div>
</div>
</nav>
</header>
<style>
    bt{
        padding: 5px 10px;
        background-color: #fdfddf;
        display: block;
    }
</style>
<?=$content?>
<footer class="footer">
<div class="container">
<p>Copyright &copy; 2016.Company name All rights reserved.<a target="_blank" href="http://sc.chinaz.com/moban/">&#x7F51;&#x9875;&#x6A21;&#x677F;</a></p>
</div>
<div id="gotop"><a class="gotop"></a></div>
</footer>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.ias.js"></script>

</body>
</html>
