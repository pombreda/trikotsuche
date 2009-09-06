<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $page['title'] ?></title>
<link rel="shortcut icon" href="<?= $page['path_img'] ?>favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="all" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?= $page['path_css'] ?>style.css" />
<script type="text/javascript" src="<?= $page['file_js'] ?>"></script>
</head>
<body>
<div id="doc-custom" class="yui-t2">
  <div id="hd">
    <div id="top" class="section">
      <?= $page['header'] ?>
    </div>
  </div>
  <div id="bd">
    <div id="main" class="section">
      <div id="yui-main">
        <div class="yui-b">
          <div id="content" class="yui-g">
            <?= $page['content'] ?>
          </div>
          <div id="pager" class="yui-g"> 
            <?= $page['pager'] ?>
          </div> 
        </div>
      </div>
      <div id="left" class="yui-b">
        <?= $page['left'] ?>
      </div>
    </div>
  </div>
  <div id="ft">
    <div id="bottom" class="section">
      <?= $page['footer'] ?>
    </div>
  </div>
  
</div>
</body>
</html>