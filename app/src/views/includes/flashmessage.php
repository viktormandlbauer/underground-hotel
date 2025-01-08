<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="alert alert-info alert-dismissible fade show" id="flashMessage">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8'); ?>
    </div>
    <script src='/public/js/flashMessage.js'></script>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>