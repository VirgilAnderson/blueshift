
<footer class="fixed-bottom text-dark bg-body border border-left-0 border-right-0 border-bottom-0">
  <div class="container pt-4 pb-2">
    <div class="row mr-auto ml-auto">
    <p>&copy; BlueShift Tech <script type="text/javaScript">var year = new Date();document.write(year.getFullYear());</script> </p>

    <ul class="nav">
      <a class="nav-item ml-3 text-dark active" href="<?php echo url_for('index.php'); ?>">Home</a>
      <a class="nav-item ml-3 text-dark" href="#">Mission</a>
      <a class="nav-item ml-3 text-dark" href="#">Services</a>
      <a class="nav-item ml-3 text-dark" href="#">Blog</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('/staff/login.php'); ?>">Login</a>
    </ul>

  </div><!-- .row -->
  </div><!-- .container -->
</footer>

<script src="<?php echo url_for('js/jquery.slim.min.js'); ?>"></script>
<script src="<?php echo url_for('js/popper.min.js'); ?>"></script>
<script src="<?php echo url_for('js/bootstrap.min.js'); ?>"></script>
</body>
</html>
