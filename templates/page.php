<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $page['title'] ?></title>
<link rel="shortcut icon" href="<?= $page['path_img'] ?>favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" media="all" href="<?= $page['file_css'] ?>" />
<script type="text/javascript" src="<?= $page['file_js'] ?>"></script>
</head>
<body>
<div class="section">
  <div id="header" class="section-wrapper">
    <?= $page['header'] ?>
  </div>
</div>
<div class="section">
  <div id="container" class="section-wrapper">
    <div id="left" class="sidebar column">
      <?= $page['left'] ?>
    </div>
    <div id="content" class="column">
      <?= $page['content'] ?>
    </div>
</div>
<div class="section">
  <div id="footer" class="section-wrapper">
    <?= $page['footer'] ?>
  </div>
</div>
</body>
</html>