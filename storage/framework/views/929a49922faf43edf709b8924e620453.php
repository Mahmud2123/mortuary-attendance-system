<?php $__env->startSection('title', 'Release Certificate'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Release Certificate</h3>
    <a href="<?php echo e(route('releases.certificate.pdf', $release)); ?>" class="btn btn-primary"><i class="bi bi-download"></i> Download PDF</a>
</div>

<div class="card certificate-card">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <h4>MORTUARY ATTENDANCE MANAGEMENT SYSTEM</h4>
            <p class="text-muted">Official Body Release Certificate</p>
            <hr>
        </div>

        <div class="row mb-4">
            <div class="col-6"><strong>Certificate No:</strong> REL-<?php echo e(str_pad($release->id, 6, '0', STR_PAD_LEFT)); ?></div>
            <div class="col-6 text-end"><strong>Date Issued:</strong> <?php echo e($release->release_date->format('d M Y')); ?></div>
        </div>

        <h5>Deceased Information</h5>
        <table class="table table-borderless mb-4">
            <tr><td width="200"><strong>Reference Number</strong></td><td><?php echo e($release->body->ref_number); ?></td></tr>
            <tr><td><strong>Full Name</strong></td><td><?php echo e($release->body->full_name); ?></td></tr>
            <tr><td><strong>Age / Sex</strong></td><td><?php echo e($release->body->age); ?> / <?php echo e(ucfirst($release->body->sex)); ?></td></tr>
            <tr><td><strong>Date of Death</strong></td><td><?php echo e(optional($release->body->date_of_death)->format('d M Y')); ?></td></tr>
        </table>

        <h5>Released To (Next of Kin)</h5>
        <table class="table table-borderless mb-4">
            <tr><td width="200"><strong>Full Name</strong></td><td><?php echo e(optional($release->kin)->full_name); ?></td></tr>
            <tr><td><strong>Relationship</strong></td><td><?php echo e(optional($release->kin)->relationship); ?></td></tr>
            <tr><td><strong>Phone</strong></td><td><?php echo e(optional($release->kin)->phone); ?></td></tr>
            <tr><td><strong>ID Verification</strong></td><td><?php echo e(optional($release->kin)->id_type); ?>: <?php echo e(optional($release->kin)->id_number); ?></td></tr>
        </table>

        <?php if($release->notes): ?>
        <h5>Notes</h5>
        <p><?php echo e($release->notes); ?></p>
        <?php endif; ?>

        <div class="row mt-5 pt-5">
            <div class="col-6 text-center"><hr><p>Authorized By: <?php echo e(optional($release->releasedBy)->full_name); ?></p></div>
            <div class="col-6 text-center"><hr><p>Received By: <?php echo e(optional($release->kin)->full_name); ?></p></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/releases/certificate.blade.php ENDPATH**/ ?>