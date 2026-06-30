<?php $__env->startSection('title', 'Attendance'); ?>

<?php $__env->startSection('content'); ?>
<h3 class="mb-4">Staff Attendance</h3>

<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h5 class="mb-1">Your Clock Status</h5>
            <?php if($myActive): ?>
                <p class="mb-0 text-success"><i class="bi bi-circle-fill"></i> Clocked in since <?php echo e($myActive->clock_in->format('h:i A, d M Y')); ?></p>
            <?php else: ?>
                <p class="mb-0 text-muted"><i class="bi bi-circle"></i> Not currently clocked in</p>
            <?php endif; ?>
        </div>
        <div class="d-flex gap-2">
            <form method="POST" action="<?php echo e(route('attendance.clock-in')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-success" <?php echo e($myActive ? 'disabled' : ''); ?>><i class="bi bi-box-arrow-in-right"></i> Clock In</button>
            </form>
            <form method="POST" action="<?php echo e(route('attendance.clock-out')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-danger" <?php echo e(!$myActive ? 'disabled' : ''); ?>><i class="bi bi-box-arrow-left"></i> Clock Out</button>
            </form>
        </div>
    </div>
</div>

<?php if(auth()->user()->isAdmin() || auth()->user()->isManagement()): ?>
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="staff_id" class="form-select">
                    <option value="">All Staff</option>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s->id); ?>" <?php echo e(request('staff_id') == $s->id ? 'selected' : ''); ?>><?php echo e($s->full_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-3"><input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>"></div>
            <div class="col-md-3"><input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>"></div>
            <div class="col-md-2"><button class="btn btn-outline-primary w-100">Filter</button></div>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><strong>Attendance History</strong></div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Staff</th><th>Clock In</th><th>Clock Out</th><th>Duration</th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(optional($log->staff)->full_name); ?></td>
                    <td><?php echo e($log->clock_in->format('d M Y, h:i A')); ?></td>
                    <td><?php echo e(optional($log->clock_out)->format('d M Y, h:i A') ?? 'Active'); ?></td>
                    <td><?php echo e($log->duration_hours ? $log->duration_hours . ' hrs' : '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">No attendance records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($logs->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/attendance/index.blade.php ENDPATH**/ ?>