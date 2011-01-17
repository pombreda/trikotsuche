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
<div id="hd_wrapper" class="section_wrapper">
  <div id="hd" class="container_12">
    <div id="site_info" class="grid_6 offset_top">
      <div id="site_name"><?= $page['site_name'] ?></div>
      <div id="site_slogan"><?= $page['site_slogan'] ?></div>
    </div>
    <div id="search_box" class="grid_6 offset_top">
      <form action="<?= $page['base_url']?>s/" method="post">
        <fieldset>
          <input id="search" type="text" name="search" value="" />
          <input class="button" type="submit" value="Suche" />
        </fieldset>
      </form>
      <div id="search_info">
        <?= $page['search_info'] ?>
      </div>
    </div>
  </div>
</div>

<div id="menu_wrapper" class="section_wrapper">
  <div id="main_menu" class="container_12">
    <?php include('./templates/country_menu.html')?>
  </div>
</div>

<div id="main" class="container_12">
  <div id="content" class="grid_9 alpha">
    <div id="page_heading">
      <h1><?= $page['page_heading'] ?></h1>
    </div>
    <div id="page">
      <?= $page['content'] ?>
    </div>
    <div id="pager" class="clearer centered">
      <?= $page['pager'] ?>
    </div>
  </div>
  <div id="right" class="grid_3 omega">
    <?= $page['right'] ?>
  </div>
</div>

<div id="ft_wrapper" class="section_wrapper">
  <div id="ft" class="container_12">
    <div id="bottom" class="centered">
      <p><?= $page['footer'] ?></p>
    </div>
  </div>
</div>

<script type="text/javascript">var base_url = '<?= $page['base_url'] ?>';</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="<?= $page['file_js'] ?>"></script>
</body>
</html>