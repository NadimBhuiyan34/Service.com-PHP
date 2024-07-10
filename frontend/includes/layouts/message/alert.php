<?php
function displayAlert($message, $backgroundColor, $icon) {
    ?>
    <div class="fixed-alert" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
        <div class="alert text-white shadow" role="alert" style="background-color: <?php echo $backgroundColor; ?>;">
            <i class="fa-solid <?php echo $icon; ?> fa-bounce fa-2xl mr-2"></i>
            <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>

            <div class="progress mt-2" style="height: 5px;">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <script>
        // Remove the message or error parameter from the URL on page load
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
    <?php
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    displayAlert($message, 'green', 'fa-check');
} else if (isset($_GET['error'])) {
    $error = $_GET['error'];
    displayAlert($error, '#610101', 'fa-ban');
}
?>
