
<footer class="text-dark bg-body border border-left-0 border-right-0 border-bottom-0">
  <div class="container pt-4 pb-2">
    <div class="row mr-auto ml-auto">
    <p>&copy; BlueShift Tech <script type="text/javaScript">var year = new Date();document.write(year.getFullYear());</script> </p>

    <ul class="nav">
      <a class="nav-item ml-3 text-dark active" href="<?php echo url_for('staff/index.php'); ?>">Dashboard</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('staff/leads/index.php'); ?>">Leads</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('staff/company/index.php'); ?>">Companies</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('staff/tasks/index.php'); ?>">Tasks</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('staff/projects/index.php'); ?>">Projects</a>
      <a class="nav-item ml-3 text-dark" href="<?php echo url_for('/staff/login.php'); ?>">Logout</a>
    </ul>

  </div><!-- .row -->
  </div><!-- .container -->
</footer>

<script src="<?php echo url_for('js/jquery.slim.min.js'); ?>"></script>
<script src="<?php echo url_for('js/popper.min.js'); ?>"></script>
<script src="<?php echo url_for('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo url_for('js/rowClick.js'); ?>"></script>
</body>
</html>
