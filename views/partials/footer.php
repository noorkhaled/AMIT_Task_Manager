</main>

<footer class="border-bottom py-3">
  <div class="container text-center text-secondary small">
    © <?= date('Y') ?> Task Manager
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
<script>
  document.querySelectorAll('.toast').forEach(function(el) {
    var t = new bootstrap.Toast(el, {
      delay: 3000,
      autohide: true
    });
    t.show();
  });
</script>
</body>

</html>