<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $page['title'] ?></title>
<link rel="shortcut icon" href="<?= $page['path_img'] ?>favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="all" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?= $page['path_css'] ?>style.css" />
</head>
<body>
<div id="doc-custom" class="yui-t1">
  <div id="hd">
    <div id="top" class="section">
      <div id="site-info">
        <div id="site-name"><?= $page['site_name'] ?></div>
        <div id="site-slogan"><?= $page['site_slogan'] ?></div>
      </div>
    </div>
  </div>
  
  <div id="bd">
    <div id="main" class="section">
      <div id="yui-main">
        <div class="yui-b">
        
          <div id="content-top" class="yui-g">
            <div id="search-display" class="yui-u first">
              <h1><?= $page['search_display'] ?></h1>
            </div>
            <div id="search-info" class="yui-u">
              <?= $page['search_info'] ?>
            </div>
          </div>
          
          <div class="yui-ge">
            <div id="content" class="yui-u first">
              <?= $page['content'] ?>
            </div>
            <div id="right" class="yui-u">
              <?= $page['right'] ?>
            </div>
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
      <p><?= $page['footer'] ?></p>
    </div>
  </div>
</div>
<script type="text/javascript">var base_url = '<?= $page['base_url'] ?>';</script>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?= $page['file_js'] ?>"></script>
</body>
</html>