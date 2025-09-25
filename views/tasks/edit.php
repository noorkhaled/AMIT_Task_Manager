<?php $base = rtrim((require __DIR__ . '/../../config/config.php')['base_url'], '/'); ?>
<div class="row justify-content-center">
  <div class="col-12 col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h1 class="h4 mb-0"><?= $title ?? 'Edit Task' ?></h1>
          <a class="btn btn-outline-secondary btn-sm" href="<?= $base ?>/tasks">Back</a>
        </div>

        <form action="<?= $base ?>/tasks/update" method="post" novalidate>
          <?= $csrfField ?>
          <input type="hidden" name="id" value="<?= (int)$task->id ?>">

          <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input class="form-control" type="text" name="title" required value="<?= htmlspecialchars($task->title) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"><?= htmlspecialchars($task->description ?? '') ?></textarea>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select class="form-select" name="status">
                <?php
                $statuses = ['pending' => 'Pending', 'in_progress' => 'In Progress', 'done' => 'Done'];
                foreach ($statuses as $k => $v) {
                  $s = $k === $task->status ? 'selected' : '';
                  echo "<option value=\"$k\" $s>$v</option>";
                }
                ?>
              </select>
            </div>
            <?php
            $tz = new DateTimeZone('Africa/Cairo'); // adjust if needed
            $tomorrow = (new DateTime('tomorrow', $tz))->format('Y-m-d');
            ?>
            <div class="col-md-6">
              <label class="form-label">Due Date</label>
              <input
                class="form-control"
                type="date"
                name="due_date"
                min="<?= $tomorrow ?>"
                value="<?= htmlspecialchars($task->due_date ?? '') ?>">
            </div>
          </div>

          <button class="btn btn-primary mt-3" type="submit">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>