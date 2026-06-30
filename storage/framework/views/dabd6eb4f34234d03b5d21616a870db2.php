<?php $__env->startSection('title', 'New Admission'); ?>

<?php $__env->startSection('content'); ?>
<h3 class="mb-4">New Body Admission</h3>

<div class="card">
    <div class="card-body">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('bodies.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo e(old('full_name')); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="<?php echo e(old('age')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sex *</label>
                    <select name="sex" class="form-select" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="unknown">Unknown</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nationality *</label>
                    <input type="text" name="nationality" class="form-control" value="<?php echo e(old('nationality', 'Nigerian')); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Death</label>
                    <input type="date" name="date_of_death" class="form-control" value="<?php echo e(old('date_of_death')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time of Death</label>
                    <input type="time" name="time_of_death" class="form-control" value="<?php echo e(old('time_of_death')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Chamber Assignment</label>
                    <select name="chamber_id" class="form-select">
                        <option value="">-- Not Assigned Yet --</option>
                        <?php $__currentLoopData = $chambers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chamber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($chamber->id); ?>"><?php echo e($chamber->name); ?> (<?php echo e($chamber->getAvailableSlots()); ?> slots free)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cause of Death</label>
                    <input type="text" name="cause_of_death" class="form-control" value="<?php echo e(old('cause_of_death')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Place of Death</label>
                    <input type="text" name="place_of_death" class="form-control" value="<?php echo e(old('place_of_death')); ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Save Admission</button>
                <a href="<?php echo e(route('bodies.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/bodies/create.blade.php ENDPATH**/ ?>