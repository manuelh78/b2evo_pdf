# b2evo_pdf - A b2evolution pdf converter 

This skin convert a post in a PDF with MPDF : https://mpdf.github.io/

# Setup
on your shell :
 - copy all files in a folder 'pdf' in the skins folder (xxx/b2evo/skins/pdf)
 - cd xxx/b2evo/skins/pdf
 - composer install (for MPDF library)

# Usage
In your skin, edit _item_block.inc.php, 

probably just after this line :
   `` <div class="evo_container evo_container__item_single">``

  add a link :
    `` <div class='small right'><a href='<? echo '/'.$Blog->urlname.'/'.$Item->get('urltitle'); ?>?tempskin=pdf'>Print (PDF)</a></div> ``
  
