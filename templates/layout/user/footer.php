<!-- Remove the container if you want to extend the Footer to full width. -->


<footer class="bg-primary text-center text-lg-start text-white">
    <!-- Grid container -->
    <div class="container p-4 footer-container">
        <!--Grid row-->
        <div class="row my-4 footer-content">
            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto" style="width: 150px; height: 150px;">
                    <img src="/News_website/templates/assets/images/TH.png" height="150" alt="Logo-brand"
                        loading="lazy" />
                </div>

                <p class="text-center">TH News Website</p>

                <ul class="list-unstyled d-flex flex-row justify-content-center">
                    <li>
                        <a class="text-white px-2" href="?module=errors&action=404">
                            <i class="fab fa-facebook-square"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white px-2" href="?module=errors&action=404">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a class="text-white ps-2" href="https://github.com/nbt2308/News_website">
                            <i class="fab fa-github"></i>
                        </a>
                    </li>
                </ul>

            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-4 text-center">Navigation</h5>

                <ul class="list-unstyled d-flex flex-column align-items-center">
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none link-danger">Home</a>
                    </li>
                    <li class="mb-2">
                        <?php $Login = getSession("logged_in"); ?>
                        <a href="<?php echo $Login ? "?module=news&action=manageNews" : "?module=auth&action=login" ?>" class=" text-white text-decoration-none link-danger">Manage your posts</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-white text-decoration-none link-danger">About us</a>
                    </li>

                </ul>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase mb-4">Contact us</h5>

                <ul class="list-unstyled">
                    <li>
                        <p><i class="fas fa-map-marker-alt pe-2"></i>Số 18, đường Ung Văn Khiêm, phường Long Xuyên, tỉnh An Giang</p>
                    </li>
                    <li>
                        <p><i class="fas fa-phone pe-2"></i>(+84) 123 456 789</p>
                    </li>
                    <li>
                        <p><i class="fas fa-envelope pe-2 mb-0"></i>thnewswebsite@gmail.com</p>
                    </li>
                </ul>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2025 Copyright:
        <a class="text-white text-decoration-none link-danger" href="#">TH News website</a>
    </div>
    <!-- Copyright -->
</footer>


<!-- End of .container -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>