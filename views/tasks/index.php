<?php
$config = require __DIR__ . '/../../config/config.php';
$base   = rtrim($config['base_url'], '/');
$totalPages = (int)ceil(($total ?? 0) / ($perPage ?? 10));
$badgeClass = fn(string $s) => [
    'pending' => 'text-bg-warning',
    'in_progress' => 'text-bg-info',
    'done' => 'text-bg-success'
][$s] ?? 'text-bg-secondary';
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h4 mb-0"><?= $title ?? 'My Tasks' ?></h1>
  <a class="btn btn-primary" href="<?= $base ?>/tasks/create">Create New Task</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Due</th>
            <th>Created</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php if (empty($tasks)): ?>
          <tr><td colspan="5" class="text-muted text-center py-4">No tasks yet.</td></tr>
        <?php else: foreach ($tasks as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t->title) ?></td>
            <td><span class="badge <?= $badgeClass($t->status) ?>"><?= htmlspecialchars($t->status) ?></span></td>
            <td><?= htmlspecialchars($t->due_date ?? '-') ?></td>
            <td><?= htmlspecialchars($t->created_at) ?></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="<?= $base ?>/tasks/edit?id=<?= (int)$t->id ?>">Edit</a>
              <a class="btn btn-sm btn-outline-primary" href="<?= $base ?>/task/show?id=<?= (int)$t->id ?>">Show</a>
              <form action="<?= $base ?>/tasks/delete" method="post" class="d-inline">
                <?= $csrfField ?>
                <input type="hidden" name="id" value="<?= (int)$t->id ?>">
                <button class="btn btn-sm btn-outline-danger"
                        type="submit"
                        onclick="return confirm('Delete this task?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php if ($totalPages > 1): ?>
<nav class="mt-3 d-flex justify-content-center">
  <ul class="pagination mb-0">
    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <li class="page-item <?= $p===$page ? 'active' : '' ?>">
        <a class="page-link" href="<?= $base ?>/tasks?page=<?= $p ?>"><?= $p ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
<?php endif; ?>
