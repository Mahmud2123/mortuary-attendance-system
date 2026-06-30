<?php $__env->startSection('title', 'Body Releases'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Body Releases</h3>
    <a href="<?php echo e(route('releases.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Process New Release</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Ref Number</th><th>Deceased</th><th>Released To</th><th>Released By</th><th>Date</th><th></th></tr></thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $releases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $release): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(optional($release->body)->ref_number); ?></td>
                    <td><?php echo e(optional($release->body)->full_name); ?></td>
                    <td><?php echo e(optional($release->kin)->full_name); ?> (<?php echo e(optional($release->kin)->relationship); ?>)</td>
                    <td><?php echo e(optional($release->releasedBy)->full_name); ?></td>
                    <td><?php echo e($release->release_date->format('d M Y')); ?></td>
                    <td>
                        <a href="<?php echo e(route('releases.certificate', $release)); ?>" class="btn btn-sm btn-outline-primary">Certificate</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">No releases recorded yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($releases->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/releases/index.blade.php ENDPATH**/ ?>