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

      <?php if ($conf['useacl'] && $showTools): ?>
        <ul class="usertools w--usertools__bg">
          <?php if ($showTools): ?>
          <?php tpl_toolsevent('pagetools', array(
            'edit'      => tpl_action('edit', 1, 'li', 1),
            'discussion'=> _tpl_action('discussion', 1, 'li', 1),
            'revisions' => tpl_action('revisions', 1, 'li', 1),
            /* 'subscribe' => tpl_action('subscribe', 1, '', 1), */
            /* 'revert'    => tpl_action('revert', 1, '', 1), */
          )); ?>
          <?php endif; ?>

          <?php tpl_toolsevent('usertools', array(
            'admin'     => tpl_action('admin', 1, 'li', 1),
            /* 'userpage'  => _tpl_action('userpage', 1, '', 1), */
            /* 'profile'   => tpl_action('profile', 1, '', 1), */
            /* 'register'  => tpl_action('register', 1, '', 1), */
            'log in'     => tpl_action('login', 1, 'li', 1),
          )); ?>
        </ul>
      <?php endif ?>
    </nav>

   <div class="dokuwiki flex flex-cl flex-row__md mg-t--flush">
      <?php if ($showSidebar): ?>
        <aside class="w--full w--third__md pd-t--1 pd-t--2__md pd-h--1 bgc-red">
          <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
        </aside>
      <?php endif; ?>

      <main class="dw w--full w--two-thirds__md pd-t--2 pd-h--1 of-scroll">
        <?php tpl_flush() /* flush the output buffer */ ?>
        <?php tpl_content() /* the main content */ ?>
        <?php tpl_pageinfo() /* 'Last modified' etc */ ?>
        <?php tpl_flush() ?>
      </main>

    <?php
      if($INFO['id'] != 'admin' AND $INFO['exists']):
    ?>

      <?php
        require 'vendor/autoload.php';
        $instance = new EtherpadLite\Client('', $baseUrl);
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
      <button class="pad-button pos-fx pos-t pos-r pos-b">P</button>
      <iframe src='http://localhost:9001/p/<?php echo $padID ?>' class="pad d-n">

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
