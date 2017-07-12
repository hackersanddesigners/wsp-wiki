<?php
/**
 * DokuWiki F.R.E.E. template
 *
 * @link     https://github.com/afincato/f-r-e-e
 * @author   André Fincato <work@andrefincato.info>
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
?>

<!doctype html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>">
<head>
  <meta charset="utf-8" />
  <title><?php tpl_pagetitle() ?> * <?php echo strip_tags($conf['title']) ?></title>
  <?php tpl_metaheaders() ?>
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
</head>

<body>
<div id="dokuwiki__site">
 <?php $usr_l = $INFO['userinfo'] ?>
 <div class="flex flex-cl site <?php echo tpl_classes(); ?><?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
   <nav class="pos-fx pos-t pos-r pos-l z-2 flex<?php echo $usr_l > 0 ? ' flex-cl flex-row__bg' : ' flex-row' ?> flex-jsb flex-aib pd-v--05 pd-h--1 bgc-white">
      <?php html_msgarea() ?>
  
      <div class="<?php echo $usr_l > 0 ? 'w--full ' : '' ?>search-wrap">
        <?php tpl_searchform() ?>
      </div>

      <?php if ($INFO['userinfo'] != ''): ?>
        <ul class="usertools">
          <?php if ($showTools): ?>
          <?php tpl_toolsevent('pagetools', array(
            'edit'      => tpl_action('edit', 1, 'li', 1),
            'revisions' => tpl_action('revisions', 1, 'li', 1)
          )); ?>
          <?php endif; ?>

          <?php tpl_toolsevent('usertools', array(
            'admin'     => tpl_action('admin', 1, 'li', 1),
            'log in'    => tpl_action('login', 1, 'li', 1)
          )); ?>
        </ul>
      <?php else: ?>
      <ul>
        <?php tpl_toolsevent('usertools', array(
          'log in'    => tpl_action('login', 1, 'li', 1)
        )); ?>
      </ul>
    <?php endif ?>
    </nav>

   <div class="dokuwiki wrapper flex flex-cl flex-row__md flex-jsb">
      <?php if ($showSidebar): ?>
        <aside class="w--full w--third__md pd-t--1 pd-b--1 pd-t--2__md pd-h--1 bgc-red xdl">
          <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
        </aside>
      <?php endif; ?>

      <?php $admin = $_REQUEST['do'] != 'admin' ?>
      <main class="dw h--full w--full<?php echo $admin > 0 ? ' w--two-thirds__bg' : '' ?> pd-b--2 pd-b--3__md pd-h--2 pd-h--3__bg of-scroll xdl">
        <div class="ta-c pd-t--1 pd-b--2">
          <?php if ($_REQUEST['do'] == 'search' OR $_REQUEST['do'] == 'admin'): ?>
            <a href="/">Home</a> ———
          <?php endif; ?>
          <?php tpl_breadcrumbs() ?>
        </div>
        <?php tpl_flush() ?>
        <?php tpl_content() ?>
        <?php tpl_flush() ?>
      </main>

    <?php
      // check if
      // user is logged in
      if ($INFO['userinfo'] != ''
      // page exists
      AND $INFO['exists']
      // page is not in 'edit' mode
      AND $_REQUEST['do'] != 'edit'
      // page is not in 'admin' mode
      AND $_REQUEST['do'] != 'admin'
      // page is not in 'search' mode
      AND $_REQUEST['do'] != 'search'
      // page is not in 'media&image' mode
      AND $_REQUEST['do'] != 'media&image'
      ):
    ?>

      <?php
        require 'vendor/autoload.php';
        $instance = new EtherpadLite\Client('', $baseUrl);
				$page = str_replace(':', '.', $INFO['id']);
        $padID = $page . '-' . $INFO['meta']['date']['created'];
        
        // listAllPads
        $padlist = $instance->listAllPads();

        // check if pad already exists, otherwise make a new one
        // --- http://thinkofdev.com/php-fast-way-to-determine-a-key-elements-existance-in-an-array/
        if(isset($padlist->padIDs[$padID]) === NULL || !in_array($padID, $padlist->padIDs)) {
          $newPad = $instance->createPad($padID);
        }
      ?>
      <div class="pad-wrap flex__md flex-jsb__md h--full__md xdl">
        <div class="pad xdsd ofy-scroll"><iframe src="http://localhost:9001/p/<?php echo $padID ?>" class="w--full h--full bd-a--0"></iframe></div>
        <button class="pad-button w--full w--auto__md h--full__md">✎</button>
      </div>

    <?php endif ?>

    </div>

    <footer>
      <?php tpl_license('button') ?>
    </footer>

  </div>
  <div class="d-n"><?php tpl_indexerWebBug() ?></div>
</div>
</body>
</html>
