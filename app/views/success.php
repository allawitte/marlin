<?php $this->layout('template', ['title' => 'Sing Up']) ?>
<div class="container">
    <div class="alert alert-success" role="alert">
        You resisted successfully! Go t your email and click activation link.
    </div>
    <p><?= $link ?></p>
</div>