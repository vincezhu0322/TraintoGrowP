<!-- Footer -->
<footer class="footer">
    <a href="index.php" class="footer__logo wow bounceInDown">
        <img src="images/logo.png" alt="image" class="imgFluid">
    </a>
    <ul class="footer__quickLinks my-4 wow bounceInUp">
        <li><a href="index.php">Home </a></li>
        <li><a href="about-us.php">About </a></li>
        <li><a href="contact-us.php">Contact Us</a></li>
        <!-- <li><a href="services.php">Services </a></li> -->
        <li><a href="#">Class Type </a></li>
    </ul>
    <ul class="socialLinks mb-4 wow bounceInDown">
        <li><a href="#"><i class='bx bxl-facebook'></i></a></li>
        <li><a href="#"><i class='bx bxl-linkedin'></i></a></li>
        <li><a href="#"><i class='bx bxl-pinterest-alt'></i></a></li>
        <li><a href="#"><i class='bx bxl-twitter'></i></a></li>
        <li><a href="#"><i class='bx bxl-google-plus'></i></a></li>
    </ul>
    <div class="footer__copyright wow bounceInUp">
        <p>&copy; Copyright 2022 Comapny Domain - All Rights Reserved</p>
        <ul class="mt-2">
            <li><a href="#">Terms & Conditions</a></li>
            <li><span></span></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>
    </div>
</footer>

<?php include 'include/js.php'; ?>
<script>
// on Load modal
$(window).load(function() {
    $('#myModal').modal('show');
});
</script>
</body>

</html>