wsp.wiki
========

# wsp.wiki

Mish-mash of heavily customised [DokuWiki](https://www.dokuwiki.org/dokuwiki#) with a dedicated [Etherpad](http://etherpad.org) running for each new wiki article.

Commissioned by [Workshop Project](http://www.workshopproject.org) for [FREE, A DESIGN EDUCATORS WORKSHOP](https://workshopproject.wiki). Design by [Anja Groten](http://anjagroten.com).

## Setup

* [DokuWiki](https://github.com/splitbrain/dokuwiki)
* [Etherpad Lite](https://github.com/ether/etherpad-lite) + [php client](https://github.com/tomnomnom/etherpad-lite-client)

DokuWiki plugins:

* [PDF.js](https://www.dokuwiki.org/plugin:pdfjs?s%5B%5D=pdf&s%5B%5D=embed) → to embed pdf files
* [Gallery](https://www.dokuwiki.org/plugin:gallery) → to create galleries of pictures from a folder
* [iframe](https://www.dokuwiki.org/plugin:iframe) → to embed different iframes, such as YouTube and Vimeo videos, soundcloud tracks, GoogleDocs files, etc 
* [imagebox](https://www.dokuwiki.org/plugin:imagebox) → to add a caption to an image
* [move](https://www.dokuwiki.org/plugin:move) → to rename a page
* [smtp](https://www.dokuwiki.org/plugin:smtp) → to send emails, eg. when an admin makes a new user account, a new confirmation email will be sent to the specified email address of that account
* [wrap](https://www.dokuwiki.org/plugin:wrap) → to add `html tags` inside the textbox of a page; useful when you want to wrap a portion of text inside a `div` with a specific `class` (to manipulate it in `css`)

## Installation

Note: the wiki runs on a digital ocean server, and I extensively followed the documentation present on the digital ocean website to set things up. For the most part though, it’s a matter of working on a unix environment with Ubuntu (in this case, but interchangeable with some other distros if you want).

The setup consists of Ubuntu 16.04.2 LTS and nginx (as it seems to work better with `node.js`).  [Let's Encrypt](https://letsencrypt.org) for the SSL certificate.

### Install DokuWiki

As stated above, I presume you already have a vps set up, and running a unix-flavored distro. Often times, many hosting providers offer the option of a one-click installation of popular software, and DokuWiki is usually one of them. 

In that case, jump to `2.` Otherwise:

1. [follow this guide](https://www.digitalocean.com/community/tutorials/how-to-install-dokuwiki-with-nginx-on-an-ubuntu-12-04-vps) to have tips on how to install DokuWiki (don't bother that the guide is marked as deprecated, start reading from the section Install and Configure DokuWiki)
2. add custom theme: copy the `free` folder ([here](https://github.com/afincato/wsp-wiki/tree/master/lib/tpl/free)) inside `/lib/tpl/` (check [this article](https://www.dokuwiki.org/template) as a reference) (note: you have to manually copy the folder inside `/lib/tpl/`, as this custom template is not available on the DokuWiki’s Extension Manager)
3. install `composer` on your vps, [see this article](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
4. run `composer install` from the same directory where `composer.json` sits, and wait for all packages to be downloaded and installed
5. replace `template.php` with custom version that you find in `/inc` ([ref](https://github.com/afincato/wsp-wiki/blob/master/inc/template.php))
6. replace `lang.php` with custom version in `/inc/lang/en` ([ref](https://github.com/afincato/wsp-wiki/blob/master/inc/lang/en/lang.php)) (some labels are different, for example: Old Revisions → History, etc — change them as you need)
7. replace `page.js` with custom version in `/lib/scripts` (the TOC button works differently) ([ref](https://github.com/hackersanddesigners/wsp-wiki/blob/master/lib/scripts/page.js))
8. for nice urls, first set some options in the panel config and update the `.htaccess` file in `/wiki` accordingly ([see this](https://www.dokuwiki.org/rewrite), and double check [this section](https://www.dokuwiki.org/rewrite#further_details_for_the_technically_savvy)), then [update nginx config file](https://www.nginx.com/resources/wiki/start/topics/recipes/dokuwiki/)

TODO: figure how to keep customised copies of the files in 5., 6. and 7. so when dokuwiki has to be upgraded there's not need to manually replace them (DW lets you make local copies of config files, but it seems to be a bit harder when you need to manipulate core files).

UPDATE: apparently no way to make a local copy of core files (clearly). Need to use `diff` when update the wiki software.

### Install Etherpad

We need to install `node.js` to be able to run etherpad (which is why we opted to setup a linux server from scratch).

* [install node.js with nvm](http://blog.pagepro.co/2017/01/25/setting-up-node-js-application-on-digital-ocean-droplet/) (in case you need to install Ubuntu software to build the nvm package, do `sudo apt-get update` and then `sudo apt-get install build-essential libssl-dev`) ([ref](https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-16-04))
* install [etherpad-lite](https://github.com/ether/etherpad-lite)
* switch to `etherpad` user, `sudo - etherpad` (if it does not exist, make one)
* make new subdomain, `pad.workshopproject.wiki`
* set reading access to let’s encrypt certificates for `etherhpad` user and `eth` group (make new group): `sudo chgrp -h group folder / file` + `sudo chgown -h user folder / file` from `/etc/` all the way down to the `live` folder and also the `/archive` folder inside `/letsencrypt`
* set ssl paths to etherpad’s `settings.json`
* [set pad to be accessible from sub domain](https://github.com/ether/etherpad-lite/wiki/How-to-put-Etherpad-Lite-behind-a-reverse-Proxy#https-only) (change `proxy pass` under `location/` from `http` to `http`)
* use subdomain url when calling the iframe from the wiki’s `main.php` file
* [set iframed etherpad to be accessible from the same server](https://www.digitalocean.com/community/questions/blocking-iframe-because-it-set-x-frame-options-to-deny) ([ref](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options))

### start Etherpad Lite instance managed by pm2

`pm2` keeps the etherpad running also we we log out from the server and in case we update the server, `pm2` restart the etherpad as well.

* [install pm2](https://www.digitalocean.com/community/tutorials/how-to-set-up-a-node-js-application-for-production-on-ubuntu-16-04)
* to start the etherpad, from your root server folder do:

```
cd /var/www/pad
pm2 start bin/run.sh --name='Etherpad-Lite'
```

This will start the Etherpad server. You can check it is correctly running by doing `pm2 list`: you will see a table with  Etherpad-Lite and the status `online`.

You’ll get a new `APIKEY.txt` in the same folder, copy that text on line 100 of `main.php` (inside `lib/tpl/free/`):

```
$instance = new EtherpadLite\Client('APIKEY', $baseUrl);
````

If you are working locally, you can simply do 

```
etherpad-lite/bin/run.sh
``` 

to start the Etherpad. Of course you can install `pm2` as well and use it on your local environment.

## Etherpad API

This is handy table to show some of the options you can use to interact with Etherpad, in case you want to extend and or add other functionalities to it. 

As of now, I set it to create a common pad group, and for each article created, to make a new pad instance inside the common pad group.


You can read more about it [here](http://etherpad.org/doc/v1.6.1/#index_api_methods). See also [this](https://github.com/ether/etherpad-lite/wiki).

| action                 | syntax |
|:--                     |:--     |
| create pad             | `http://0.0.0.0:9001/api/1/createPad?apikey=xxx&padID=ll&text=aaaaaaa` |
| create group           | `http://0.0.0.0:9001/api/1/createGroupIfNotExistsFor?apikey=xxx&groupMapper=tttt` |
| create group pad       | `http://0.0.0.0:9001/api/1/createGroupPad?apikey=xxx&groupID=g.xxx&padName=samplePad&text=first-sentence` |
| get text               | `http://0.0.0.0:9001/api/1/getText?apikey=xxx&padID=g.xxx$samplePad` |
| list all pads in group | `http://0.0.0.0:9001/api/1/listPadsapikey=xxx&groupID=g.xxx` |

## DokuWiki plugin-specific syntax

Once you setup all the dokuwiki plugins listed above, you can use them by following these tips and syntax.

### Add a PDF

1. upload the pdf through the file manager and add it to the page. you’ll get something like this `{{file.pdf}}`
2. add the following syntax to make the pdf browsable once the article will be saved:

	`pdfjs>`, so you'll have 

	`{{pdfjs>:file.pdf}}`

	notice the colon after the major sign and before the filename

	`{{pdfjs>:ns:document.pdf}}`

→ [ref](https://www.dokuwiki.org/plugin:pdfjs?s[]=pdf&s[]=embed)

### Add an iframe

`{{url>url-to-page/file/etc}}`

for vimeo, click on the share button, then iframe and copy only the url after `iframe src=`, eg

```
<iframe src="https://player.vimeo.com/video/223456771" width="640" height="270" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<p><a href="https://vimeo.com/223456771">Mouse</a> from <a href="https://vimeo.com/elofilmproductions">ELO films</a> on <a href="https://vimeo.com">Vimeo</a>.</p>
``` 

→ `https://player.vimeo.com/video/223456771`

for youtube, click on embed, then copy only the url after `src=`, eg

```
<iframe width="560" height="315" src="https://www.youtube.com/embed/AWQcDlHoE4o" frameborder="0" allowfullscreen></iframe>
``` 
→ `https://www.youtube.com/embed/AWQcDlHoE4o`

### Add an image gallery

- Open the file uploader (click `Edit this page` on any article)
- Select, or drag and drop a file over the 'Select File’ / Upload area 

	Before clicking on Upload, prepend to the filename a ’namespace’ in the form of:

	`namespace:file.jpg`

	A namespace is a folder in the wiki parlance.

	Since we need a namespace to create a gallery, I suggest to choose a name for the above namespace that makes semantically sense, or that is a clear reminder to the image gallery you want to create, etc.
	
![](https://github.com/afincato/wsp-wiki/blob/master/dw-upload-button.png)

- Once you have uploaded the first file, the prepended namespace will be visible on the tree menu in the Media File column (eg, playground, test, etc)

![](https://github.com/afincato/wsp-wiki/blob/master/dw-upload-panel.png)

- Now click on the newly created namespace, then drag and drop all the rest of pictures you want to upload. check if they are all correctly uploaded inside that namespace/folder
- Close the File Manager window and create the image gallery like this

	`{{gallery>:namespace}}`

	Notice again the colon before the namespace

### Add a googledoc

For example, the following code:

```
{{url>https://docs.google.com/presentation/d/128wLi-xq23i6PUsZyksZ0svBX-uE8-iQF18OjHYFS_8/embed?start=false&loop=false&delayms=3000}}
```

will embed a google slides document. To get the link, either for a google slides or google docs, go to `File > Publish to the web` and select the `Embed` tag. From there, you will have a link like this

```
<iframe src="https://docs.google.com/document/d/1uDwoni0Lhy0-xbX8rfJLg5gYygxgAvNC5MfbjVtf8cM/pub?embedded=true"></iframe>
```

Copy only the actual link within `src=“”`, eg

```
https://docs.google.com/document/d/1uDwoni0Lhy0-xbX8rfJLg5gYygxgAvNC5MfbjVtf8cM/pub?embedded=true
```

and put it like so

```
{{url>https://docs.google.com/document/d/1uDwoni0Lhy0-xbX8rfJLg5gYygxgAvNC5MfbjVtf8cM/pub?embedded=true}}
```

## Dev note

Dokuwiki is still dependant on an old version of the css preprocessor [less](https://en.wikipedia.org/wiki/Less_(stylesheet_language)). This caused me some problem syntax wise. Also, it heavily uses jQuery, which can be a burden or a relief depending on your approach and background.
