<?php
$title = "Dashboard";
$headerImage = 'https://plus.unsplash.com/premium_photo-1661962685099-c6a685e6c61d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D';
// mulai tampung HTML seperti @section('content')
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row row-deck row-cards ">
            <div class="col-12">
                <div class="row row-cards row-evenly">

                    <div class="col-sm-6 col-lg-4 mt-6 p-4">
                        <h2 class="h2 text-center mb-4">Ini Dashboard <?= $_SESSION['user']['nama'] ?></h2>
                        <form action="./" method="get" autocomplete="off" novalidate="">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="email" class="form-control" placeholder="Masukkan username..." autocomplete="off">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">
                                    Password
                                </label>
                                <div class="input-group input-group-flat">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password..." autocomplete="off">
                                    <span class="input-group-text" id="togglePassword" data-bs-toggle="tooltip">
                                        <a href="#" class="link-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                            </svg></a>
                                    </span>
                                </div>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary w-100">Masuk</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto">
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="<?= BASE_URL ?>/?page=logout" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                                    <path d="M15 12h-12l3 -3" />
                                    <path d="M6 15l-3 -3" />
                                </svg>
                                Logout
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const spinner = document.getElementById("spinner");
        const pageContent = document.getElementById("page-content");

        window.addEventListener("load", function() {
            spinner.style.display = "none";
            pageContent.style.display = "block";
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordInput = $('#password');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
    });
</script>

<?php
$content = ob_get_clean();

// panggil layout utama seperti @extends
include __DIR__ . '/../layouts/main.php';
