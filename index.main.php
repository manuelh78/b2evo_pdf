<?php
/**
 * This is a PDF viewer template.
 *
 * Author : manuelh78 [at] gmail.com
 *
 * A skin used to convert a post in a pdf (probably for print).
 *
 * @package skins
 * @subpackage pdf
 */
if (! defined('EVO_MAIN_INIT'))
    die('Please, do not access this page directly.');

if (evo_version_compare($app_version, '2.4.1') < 0) { // Older 2.x skins work on newer 2.x b2evo versions, but newer 2.x skins may not work on older 2.x b2evo versions.
    die('This skin is designed for b2evolution 2.4.1 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.');
}

// We use MPDF : on your shell : "composer require mpdf/mpdf"
require '_config.php';
require MPDF_VENDOR_PATH . '/vendor/autoload.php';

// Do inits depending on current $disp:
skin_init($disp);



$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 25,
    'margin_right' => 25
]);
// $mpdf->debug = true;

$Item = & mainlist_get_item();
$dbg = '';
// $dbg = var_export($Item,true);
// $dbg = var_export($Blog,true);

// blog name
$blog_ID = intval(get_catblog($Item->main_cat_ID));
$BlogCache = & get_BlogCache();
$Blog = & $BlogCache->get_by_ID($blog_ID, false, false);
ob_start();
$Blog->longdesc(array());
$blogName = trim(ob_get_clean());

// texts
$title = $Item->title;
$title = htmlspecialchars_decode($title);
$content = $Item->render_inline_tags($Item->get_content_page());
$content = str_replace('[teaserbreak]', '', $content);
$filename = "$title.pdf";
$filename = str_replace(" ", '_', $filename);

// logo
if (! preg_match('#<!--\s*pdf_nologo\s*-->#mius', $content, $matches, PREG_OFFSET_CAPTURE)) {
    $blogLogoObj = $Blog->get('collection_image');
    // var_dump($blogLogoObj);
    if ($blogLogoObj)
        $blogLogo = $blogLogoObj->_adfp_full_path;
}

// cat
$ChapterCache = & get_ChapterCache();
if ($ChapterCache == NULL)
    return "Error : ChapterCache null";
$cat = $ChapterCache->get_by_ID($Item->main_cat_ID, false);
if ($cat != NULL)
    $mpdf->SetSubject($cat->name);

$mpdf->SetTitle($title);
$mpdf->SetAuthor($blogName);

// # https://mpdf.github.io/reference/mpdf-variables/aliasnbpg.html
$mpdf->setFooter('{PAGENO}/{nbpg}');

// html source to convert by MPDF
$html = 
"<html>
    <head>
    <style>
        body { font-family: DejaVuSansCondensed; } 
        .content { text-align: justify; text-justify: inter-word;}
        .small { font-size:10px; }
        .logo { width:150px;  } 
        .pull-left { float:left; width:25%; }
        .pull-right { float:right; width:25%; }
        .copyright { text-align: justify; }
    </style>
    </head>
    <body>
    <div class='header'>
";

//Add a logo ?
if (isset($blogLogo) && $blogLogo != '')
    $html .= "<img class='logo' src='$blogLogo'/>";

$html .= 
"<h1>$title</h1>
<p><small>$Item->last_touched_ts</small></p>
</div>

<div class='content'>$content</div>
<hr>
<div class='copyright text-center'>
    <p>
    Ce document a été rédigé par $blogName. Vous n’avez pas le droit de le modifier, de le transformer ou de l’adapter. Vous n'avez pas le droit de l'utiliser à des fins commerciales.
    </p>
    <p> $blogName - Tous droits réservés - © " . date("Y") . "</p>
</div>
$dbg

</body>
</html>";

$mpdf->WriteHTML($html);
$mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);

?>


