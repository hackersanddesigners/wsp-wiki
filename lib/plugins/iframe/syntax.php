<?php
/**
 * Plugin Iframe: Inserts an iframe element to include the specified url
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Christopher Smith <chris@jalakai.co.uk>
 */
 // must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_iframe extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }
    function getSort() { return 305; }
    function connectTo($mode) { $this->Lexer->addSpecialPattern('{{url>.*?}}',$mode,'plugin_iframe'); }

    function handle($match, $state, $pos, Doku_Handler $handler){
        $match = substr($match, 6, -2);
        list($url, $alt)   = explode('|',$match,2);
        list($url, $param) = explode(' ',$url,2);

        // javascript pseudo uris allowed?
        if (!$this->getConf('js_ok') && substr($url,0,11) == 'javascript:'){
            $url = false;
        }

        // set defaults
        $opts = array(
                    'url'    => $url,
                    'alt'    => $alt,
                    'scroll' => true,
                    'border' => true,
                    'align'  => false,
                    'allowfullscreen' => true,
                    'mozallowfullscreen' => true,
                    'webkitallowfullscreen' => true,
                );

        // handle other parameters
        if(preg_match('/noscroll(bars?|ing)?/',$param)){
            $opts['scroll'] = false;
        }
        if(preg_match('/no(frame)?border/',$param)){
            $opts['border'] = false;
        }
        if(preg_match('/(left|right)/',$param,$matches)){
            $opts['align'] = $matches[1];
        }
        if(preg_match('/(allowfullscreen)/',$param,$matches)){
           $opts['allowfullscreen'] = $matches[1];
        }
        if(preg_match('/(mozallowfullscreen)/',$param,$matches)){
           $opts['mozallowfullscreen'] = $matches[1];
        }
        if(preg_match('/(webkitallowfullscreen)/',$param,$matches)){
           $opts['webkitallowfullscreen'] = $matches[1];
        }

        return $opts;
    }

    function render($mode, Doku_Renderer $R, $data) {
        if($mode != 'xhtml') return false;

        if(!$data['url']){
            $R->doc .= '<div class="iframe">'.hsc($data['alt']).'</div>';
        }else{
            $opts = array(
                        'title' => $data['alt'],
                        'src'   => $data['url'],
                        );
            if(!$data['border']) $opts['frameborder'] = 0;
            if(!$data['scroll']) $opts['scrolling'] = 'no';
            if($data['align'])   $opts['align'] = $data['align'];
            if($data['allowfullscreen'])   $opts['allowfullscreen'] = $data['allowfullscreen'];
            if($data['mozallowfullscreen'])   $opts['mozallowfullscreen'] = $data['mozallowfullscreen'];
            if($data['webkitallowfullscreen'])   $opts['webkitallowfullscreen'] = $data['webkitallowfullscreen'];
            $params = buildAttributes($opts);
            $R->doc .= "<div class='embed'><iframe $params>".hsc($alt).'</iframe></div>';
        }

        return true;
    }
}
