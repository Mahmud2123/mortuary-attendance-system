<?php $__env->startSection('title', 'Chambers'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Cold Storage Chambers</h3>
    <?php if(auth()->user()->isAdmin()): ?>
        <a href="<?php echo e(route('chambers.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Chamber</a>
    <?php endif; ?>
</div>

<div class="row g-3">
    <?php $__currentLoopData = $chambers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chamber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-4 col-lg-3">
        <div class="card chamber-card border-<?php echo e($chamber->status_color); ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h5><?php echo e($chamber->name); ?></h5>
                    <span class="badge bg-<?php echo e($chamber->status_color); ?>"><?php echo e(ucfirst($chamber->status)); ?></span>
                </div>
                <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> <?php echo e($chamber->location); ?></p>
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-<?php echo e($chamber->status_color); ?>" style="width: <?php echo e($chamber->occupancy_percent); ?>%"></div>
                </div>
                <p class="mb-3"><?php echo e($chamber->current_occupancy); ?> / <?php echo e($chamber->capacity); ?> occupied</p>
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('chambers.show', $chamber)); ?>" class="btn btn-sm btn-outline-primary flex-fill">View</a>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('chambers.edit', $chamber)); ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/chambers/index.blade.php ENDPATH**/ ?>