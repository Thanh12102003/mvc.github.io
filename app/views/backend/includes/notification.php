<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success" role="alert" id="success-alert">
        <?= htmlspecialchars($_GET['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger" role="alert" id="error-alert">
        <?= htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<script>
    // Function to hide alert after 2 seconds
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');

        if (successAlert) {
            successAlert.classList.add('fade'); // You can use fade effect if you like
            successAlert.style.display = 'none'; // Hide the success alert
        }

        if (errorAlert) {
            errorAlert.classList.add('fade'); // You can use fade effect if you like
            errorAlert.style.display = 'none'; // Hide the error alert
        }
    }, 2000); // 2 seconds
</script>