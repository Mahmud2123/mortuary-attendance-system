<?php $__env->startSection('title', 'Chamber Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><?php echo e($chamber->name); ?></h3>
    <?php if(auth()->user()->isAdmin()): ?>
    <form method="POST" action="<?php echo e(route('chambers.destroy', $chamber)); ?>" onsubmit="return confirm('Delete this chamber?')">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button class="btn btn-outline-danger" <?php echo e($chamber->current_occupancy > 0 ? 'disabled' : ''); ?>><i class="bi bi-trash"></i> Delete</button>
    </form>
    <?php endif; ?>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="stat-card bg-secondary-soft"><i class="bi bi-geo-alt"></i><div><h5 class="mb-0"><?php echo e($chamber->location); ?></h5><p>Location</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-info-soft"><i class="bi bi-grid"></i><div><h3><?php echo e($chamber->capacity); ?></h3><p>Capacity</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-warning-soft"><i class="bi bi-box"></i><div><h3><?php echo e($chamber->current_occupancy); ?></h3><p>Occupied</p></div></div></div>
    <div class="col-md-3"><div class="stat-card bg-<?php echo e($chamber->status_color); ?>-soft"><i class="bi bi-info-circle"></i><div><h5 class="mb-0"><?php echo e(ucfirst($chamber->status)); ?></h5><p>Status</p></div></div></div>
</div>

<div class="card">
    <div class="card-header"><strong>Bodies Currently in This Chamber</strong></div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Ref Number</th><th>Name</th><th>Date of Death</th><th></th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $chamber->bodies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($body->ref_number); ?></td>
                    <td><?php echo e($body->full_name); ?></td>
                    <td><?php echo e(optional($body->date_of_death)->format('d M Y')); ?></td>
                    <td><a href="<?php echo e(route('bodies.show', $body)); ?>" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="text-center text-muted py-4">No bodies currently stored in this chamber.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/chambers/show.blade.php ENDPATH**/ ?>