<?php if($page->editable()): ?>
<nav id="manager-bar">
    <a href="<?php echo $config->urls->admin; ?>page/edit/?id=<?php echo $target->id; ?>">edit</a>
    <a href="<?php echo $config->urls->admin; ?>">admin</a>
    <a href="<?php echo $config->urls->admin; ?>login/logout">logout</a>
    <a href="#" class="frontend-debug">Layout debug: <i>off</i></a>
</nav>
<?php endif; ?>
