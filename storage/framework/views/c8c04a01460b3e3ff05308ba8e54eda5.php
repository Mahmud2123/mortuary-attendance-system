<?php $__env->startSection('title', 'Bodies'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Body Records</h3>
    <?php if(auth()->user()->isAdmin() || auth()->user()->isAttendant()): ?>
        <a href="<?php echo e(route('bodies.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Admission</a>
    <?php endif; ?>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name or ref number" value="<?php echo e(request('search')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <?php $__currentLoopData = ['admitted','in_storage','released','transferred']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($s); ?>" <?php echo e(request('status') == $s ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="from" class="form-control" value="<?php echo e(request('from')); ?>" title="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="to" class="form-control" value="<?php echo e(request('to')); ?>" title="To date">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100"><i class="bi bi-search"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr><th>Ref Number</th><th>Name</th><th>Age</th><th>Sex</th><th>Chamber</th><th>Status</th><th>Admitted</th><th></th></tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bodies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($body->ref_number); ?></td>
                    <td><?php echo e($body->full_name); ?></td>
                    <td><?php echo e($body->age ?? '-'); ?></td>
                    <td><?php echo e(ucfirst($body->sex)); ?></td>
                    <td><?php echo e(optional($body->chamber)->name ?? '-'); ?></td>
                    <td><span class="badge bg-<?php echo e($body->status_badge); ?>"><?php echo e(ucfirst(str_replace('_',' ', $body->status))); ?></span></td>
                    <td><?php echo e($body->created_at->format('d M Y')); ?></td>
                    <td><a href="<?php echo e(route('bodies.show', $body)); ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">No body records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($bodies->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/bodies/index.blade.php ENDPATH**/ ?>