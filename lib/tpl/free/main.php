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
  <div class="site <?php echo tpl_classes(); ?>
    <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
    <div class="pos-fx pos-t pos-l pos-r flex-row flex-jsb pd-v--1 pd-h--1 bgc-white">
    <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>

    <!-- search -->
    <div class="w--full w--search__bg">
      <?php tpl_searchform() ?>
    </div>

    <!-- user tools -->
    <?php if ($conf['useacl'] && $showTools): ?>
      <div class="w--full usertools w--usertools__bg flex-row flex-jsb">
      <!-- page actions -->
      <ul>
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

      <?php
        if (!empty($_SERVER['REMOTE_USER'])) {
          echo '<p class="user d-ib">';
          tpl_userinfo();
          echo '</p>';
        }
      ?>
      </div>
    </div>
    <?php endif ?>

  <div class="flex-row flex-jsb">

    <!-- aside -->
    <?php if ($showSidebar): ?>
      <div class="w--third__md  pd-t--2 pd-h--1 bgc-red">
        <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
      </div>
    <?php endif; ?>

    <!-- content -->
    <div class="dw w--two-thirds__md pd-t--2 pd-h--1">
      <?php tpl_flush() /* flush the output buffer */ ?>

      <?php tpl_content() /* the main content */ ?>

      <?php tpl_flush() ?>
    </div>

  </div><!-- /wrapper -->

  <!-- footer -->
  <div class="dw">
    <?php tpl_pageinfo() /* 'Last modified' etc */ ?>
    <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
  </div>

</div><!-- /site -->

<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</body>
</html>
