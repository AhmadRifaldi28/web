<!-- <div class="text-center p-3 border-top border-black bg-black">
  © 2020 Copyright:
  <a class="text-white" href="">MDBootstrap.com</a>
</div> -->

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>

<!-- Vendor JS -->
<script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/vendor/aos/aos.js') ?>"></script>
<script src="<?= base_url('assets/vendor/purecounter/purecounter_vanilla.js') ?>"></script>
<script src="<?= base_url('assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>

<!-- Main JS -->
<script src="<?= base_url('assets/js/main.js') ?>"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const currentUrl = window.location.pathname;
    document.querySelectorAll("#navmenu a").forEach(link => {
      if (link.href.includes(currentUrl)) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });
  });
</script>
</body>

</html>