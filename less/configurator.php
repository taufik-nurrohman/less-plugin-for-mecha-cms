<?php $c_less = $config->states->{'plugin_' . md5(File::B(__DIR__))}; ?><label class="grid-group">
  <span class="grid span-1 form-label"><?php echo $speak->plugin_less->title->format; ?></span>
  <span class="grid span-5"><?php echo Form::select('formatterName', $speak->plugin_less->title->formatter, $c_less->formatterName); ?></span>
</label>
<div class="grid-group">
  <span class="grid span-1"></span>
  <span class="grid span-5"><?php echo Form::checkbox('preserveComments', 1, isset($c_less->preserveComments), $speak->plugin_less->title->preserve_comments); ?></span>
</div>