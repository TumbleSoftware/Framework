<?php
  $form = new form('add_node',FORM_AJAX,'./ajaxaddnode.php','add-node',FORM_INLINE,0);
  $segment = $form->segment('add-node-inline', FORM_INLINE);
  $segment->add_text_input('menu_title','Node Title','','','');
  $segment->add_text_input('menu_description','Node Description','','','');
  $segment->add_submit_button('button','add-node-submit-button', 'Add');
  $form->ajax('./ajaxaddnode.php','add-node-submit-button','POST','click','JSON', $database);
?>