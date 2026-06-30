<?php $__env->startSection('title', 'Edit Body Record'); ?>

<?php $__env->startSection('content'); ?>
<h3 class="mb-4">Edit Body Record — <?php echo e($body->ref_number); ?></h3>

<div class="card">
    <div class="card-body">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('bodies.update', $body)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="full_name" class="form-control" value="<?php echo e(old('full_name', $body->full_name)); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control" value="<?php echo e(old('age', $body->age)); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sex *</label>
                    <select name="sex" class="form-select" required>
                        <?php $__currentLoopData = ['male','female','unknown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($body->sex == $s ? 'selected' : ''); ?>><?php echo e(ucfirst($s)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Nationality *</label>
                    <input type="text" name="nationality" class="form-control" value="<?php echo e(old('nationality', $body->nationality)); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Date of Death</label>
                    <input type="date" name="date_of_death" class="form-control" value="<?php echo e(old('date_of_death', optional($body->date_of_death)->format('Y-m-d'))); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Time of Death</label>
                    <input type="time" name="time_of_death" class="form-control" value="<?php echo e(old('time_of_death', $body->time_of_death)); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <?php $__currentLoopData = ['admitted','in_storage','released','transferred']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($s); ?>" <?php echo e($body->status == $s ? 'selected' : ''); ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cause of Death</label>
                    <input type="text" name="cause_of_death" class="form-control" value="<?php echo e(old('cause_of_death', $body->cause_of_death)); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Place of Death</label>
                    <input type="text" name="place_of_death" class="form-control" value="<?php echo e(old('place_of_death', $body->place_of_death)); ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e(old('notes', $body->notes)); ?></textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Record</button>
                <a href="<?php echo e(route('bodies.show', $body)); ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/bodies/edit.blade.php ENDPATH**/ ?>