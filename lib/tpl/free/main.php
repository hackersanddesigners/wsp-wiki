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
 <div class="flex flex-cl site <?php echo tpl_classes(); ?><?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
   <nav class="pos-fx pos-t pos-r pos-l z-2 flex__bg flex-row__bg pd-v--1 pd-h--1 bgc-white">
      <?php html_msgarea() ?>

      <div class="w--full w--search__bg">
        <?php tpl_searchform() ?>
      </div>

      <?php if ($INFO['userinfo'] != ''): ?>
        <ul class="usertools w--usertools__bg">
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

   <div class="dokuwiki flex flex-cl flex-row__md flex-jsb mg-t--flush">
      <?php if ($showSidebar): ?>
        <aside class="w--full w--third__md pd-v--05 pd-t--2__md pd-h--1 bgc-red">
          <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
        </aside>
      <?php endif; ?>

      <main class="dw h--full w--full w--two-thirds__bg pd-t--2 pd-h--1 of-scroll">
        <div class="pd-b--2"><?php tpl_breadcrumbs() ?></div>
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
      ):
    ?>

      <?php
        require 'vendor/autoload.php';
        $instance = new EtherpadLite\Client('2e30bec97cdce21ea0f9f4e4c6b38755d7139b8adb9258981192b785a69ca684', $baseUrl);
        $padID = $INFO['id'] . '-' . $INFO['meta']['date']['created'];
        
        // createGroup
        $group = $instance->createGroupIfNotExistsFor('f-r-e-e');
          
        // listAllPads
        $padlist = $instance->listAllPads();

        // check if pad already exists, otherwise make a new one
        // --- http://thinkofdev.com/php-fast-way-to-determine-a-key-elements-existance-in-an-array/
        if(isset($padlist->padIDs[$padID]) === NULL || !in_array($padID, $padlist->padIDs)) {
          $newPad = $instance->createPad($padID);
          echo "new pad $padID";
        }
      ?>
      <iframe src='http://localhost:9001/p/<?php echo $padID ?>' class="pad d-n bd-a--0 mh--half"></iframe>
      <button class="pad-button"><p>P</p></button>

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
