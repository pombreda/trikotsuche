<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $page['title'] ?></title>
<link rel="shortcut icon" href="<?= $page['path_img'] ?>favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="RSS feed" href="<?= $page['rss_url'] ?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?= $page['path_css'] ?>style.css" />
</head>
<body>
<div id="hd" class="container_12">

<!--
  <div id="top" class="section">
    <div id="site_info">
      <div id="site_name"><?= $page['site_name'] ?></div>
      <div id="site_slogan"><?= $page['site_slogan'] ?></div>
    </div>
    <div id="search_box">
      <form action="<?= $page['base_url']?>s/" method="post">
        <fieldset>
          <input id="search" type="text" name="search" value="" />
          <input class="button" type="submit" value="Suche" />
        </fieldset>
      </form>
    </div>
  </div>
</div>
-->

<div id="main_menu" class="container_12">
  <?php include('./templates/country_menu.html')?>
</div>

<div id="content-top" class="container_12">
  <div id="search-display">
    <h1><?= $page['search_display'] ?></h1>
  </div>
  <div id="search-info">
    <?= $page['search_info'] ?>
  </div>
</div>

<div id="main" class="container_12">
  <div id="content" class="grid_9">
    <?= $page['content'] ?>
  </div>
  <div id="right" class="grid_3">
    <?= $page['right'] ?>
  </div>
</div>

<div id="pager" class="container_12"> 
  <?= $page['pager'] ?>
</div>

<div id="ft" class="container_12">
  <div id="bottom">
    <p><?= $page['footer'] ?></p>
  </div>
</div>

<script type="text/javascript">var base_url = '<?= $page['base_url'] ?>';</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="<?= $page['file_js'] ?>"></script>
</body>
</html>