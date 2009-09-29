<?php print '<?xml version="1.0" encoding="utf-8" ?>'; ?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
<channel>
<title><?= $page['title'] ?></title>
<link><?= $page['url'] ?></link>
<description><?= $page['description'] ?></description>
<language>de-de</language>
<pubDate><?= $page['rss_date'] ?></pubDate>
<lastBuildDate><?= $page['rss_date'] ?></lastBuildDate>
<?= $page['content'] ?>
</channel>
</rss>