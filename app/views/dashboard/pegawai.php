<?php
$title = "Dashboard";
$headerImage = 'https://images.unsplash.com/photo-1587387119725-9d6bac0f22fb?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8aG9yaXpvbnRhbHxlbnwwfHwwfHx8MA%3D%3D';

// mulai tampung HTML seperti @section('content')
ob_start();
?>

<div class="page-body mt-3" id="page-content" style="display:none;">

    <div class="container-xl">
        <div class="row space-between">
            <div class="col">
                <a href="#" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                    </svg>
                    Dashboard
                </a>
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

        <hr class="mt-3 mb-3">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="row row-cards row-evenly">

                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3 p-3">
                        <a href="#" class="card card-link card-link-pop">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(https://images.unsplash.com/photo-1598084991519-c90900bc9df0?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGhvcml6b250YWx8ZW58MHx8MHx8fDA%3D)"></div>
                            <div class="card-body h2 text-center mb-0">
                                Card with top image
                            </div>
                        </a>
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
