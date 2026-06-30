<?php $__env->startSection('title', 'Body Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0"><?php echo e($body->full_name); ?> <span class="text-muted fs-6">(<?php echo e($body->ref_number); ?>)</span></h3>
    <div class="d-flex gap-2">
        <?php if(auth()->user()->isAdmin() || auth()->user()->isAttendant()): ?>
            <a href="<?php echo e(route('bodies.edit', $body)); ?>" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
            <form method="POST" action="<?php echo e(route('bodies.destroy', $body)); ?>" onsubmit="return confirm('Delete this record permanently?')">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
            </form>
        <?php endif; ?>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header"><strong>Body Information</strong></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Status:</strong> <span class="badge bg-<?php echo e($body->status_badge); ?>"><?php echo e(ucfirst(str_replace('_',' ',$body->status))); ?></span></div>
                    <div class="col-md-6 mb-2"><strong>Chamber:</strong> <?php echo e(optional($body->chamber)->name ?? 'Not Assigned'); ?></div>
                    <div class="col-md-6 mb-2"><strong>Age:</strong> <?php echo e($body->age ?? '-'); ?></div>
                    <div class="col-md-6 mb-2"><strong>Sex:</strong> <?php echo e(ucfirst($body->sex)); ?></div>
                    <div class="col-md-6 mb-2"><strong>Nationality:</strong> <?php echo e($body->nationality); ?></div>
                    <div class="col-md-6 mb-2"><strong>Date of Death:</strong> <?php echo e(optional($body->date_of_death)->format('d M Y') ?? '-'); ?></div>
                    <div class="col-md-6 mb-2"><strong>Time of Death:</strong> <?php echo e($body->time_of_death ?? '-'); ?></div>
                    <div class="col-md-6 mb-2"><strong>Cause of Death:</strong> <?php echo e($body->cause_of_death ?? '-'); ?></div>
                    <div class="col-md-12 mb-2"><strong>Place of Death:</strong> <?php echo e($body->place_of_death ?? '-'); ?></div>
                    <div class="col-md-6 mb-2"><strong>Admitted By:</strong> <?php echo e(optional($body->admittedBy)->full_name); ?></div>
                    <div class="col-md-6 mb-2"><strong>Admitted On:</strong> <?php echo e($body->created_at->format('d M Y, h:i A')); ?></div>
                    <?php if($body->notes): ?>
                        <div class="col-12"><strong>Notes:</strong> <?php echo e($body->notes); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header"><strong>Chamber Assignment History</strong></div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Chamber</th><th>Assigned At</th><th>Vacated At</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $body->assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(optional($a->chamber)->name); ?></td>
                            <td><?php echo e($a->assigned_at->format('d M Y, h:i A')); ?></td>
                            <td><?php echo e(optional($a->vacated_at)->format('d M Y, h:i A') ?? 'Currently Stored'); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" class="text-center text-muted py-3">No chamber assignment history.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Next of Kin</strong>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kinModal"><i class="bi bi-plus-lg"></i></button>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $body->nextOfKins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between">
                            <strong><?php echo e($kin->full_name); ?></strong>
                            <form method="POST" action="<?php echo e(route('bodies.kins.destroy', [$body, $kin])); ?>" onsubmit="return confirm('Remove this next of kin?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-sm btn-link text-danger p-0"><i class="bi bi-x-lg"></i></button>
                            </form>
                        </div>
                        <div class="small text-muted"><?php echo e($kin->relationship); ?> &bull; <?php echo e($kin->phone); ?></div>
                        <?php if($kin->id_type): ?><div class="small text-muted"><?php echo e($kin->id_type); ?>: <?php echo e($kin->id_number); ?></div><?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted small mb-0">No next of kin recorded yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php if(in_array($body->status, ['admitted', 'in_storage'])): ?>
        <div class="card">
            <div class="card-body">
                <a href="<?php echo e(route('releases.create')); ?>" class="btn btn-success w-100"><i class="bi bi-box-arrow-right"></i> Process Release</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Next of Kin Modal -->
<div class="modal fade" id="kinModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo e(route('bodies.kins.store', $body)); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add Next of Kin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2"><label class="form-label">Full Name *</label><input type="text" name="full_name" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Relationship *</label><input type="text" name="relationship" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Phone *</label><input type="text" name="phone" class="form-control" required></div>
                    <div class="mb-2"><label class="form-label">Email</label><input type="email" name="email" class="form-control"></div>
                    <div class="row">
                        <div class="col-6 mb-2"><label class="form-label">ID Type</label><input type="text" name="id_type" class="form-control"></div>
                        <div class="col-6 mb-2"><label class="form-label">ID Number</label><input type="text" name="id_number" class="form-control"></div>
                    </div>
                    <div class="mb-2"><label class="form-label">Address</label><textarea name="address" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/bodies/show.blade.php ENDPATH**/ ?>