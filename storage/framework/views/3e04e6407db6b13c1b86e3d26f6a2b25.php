<?php $__env->startSection('title', 'Staff Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Staff Management</h3>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Staff Account</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead><tr><th>Staff ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
            <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($user->staff_id); ?></td>
                    <td><?php echo e($user->full_name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><span class="badge bg-secondary text-uppercase"><?php echo e($user->role); ?></span></td>
                    <td><span class="badge bg-<?php echo e($user->status === 'active' ? 'success' : 'danger'); ?>"><?php echo e(ucfirst($user->status)); ?></span></td>
                    <td class="d-flex gap-2">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <?php if($user->id !== auth()->id() && $user->status === 'active'): ?>
                        <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>" onsubmit="return confirm('Deactivate this account?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-outline-danger">Deactivate</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer"><?php echo e($users->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/users/index.blade.php ENDPATH**/ ?>