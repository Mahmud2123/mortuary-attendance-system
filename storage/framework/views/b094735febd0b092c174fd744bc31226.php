<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<h3 class="mb-4">Dashboard Overview</h3>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-primary-soft">
            <i class="bi bi-person-lines-fill"></i>
            <div><h3><?php echo e($stats['total_bodies']); ?></h3><p>Total Bodies</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-info-soft">
            <i class="bi bi-snow"></i>
            <div><h3><?php echo e($stats['in_storage']); ?></h3><p>In Storage</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-warning-soft">
            <i class="bi bi-box-arrow-in-down"></i>
            <div><h3><?php echo e($stats['admitted_today']); ?></h3><p>Admitted Today</p></div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card bg-success-soft">
            <i class="bi bi-box-arrow-right"></i>
            <div><h3><?php echo e($stats['released_today']); ?></h3><p>Released Today</p></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="stat-card bg-secondary-soft">
            <i class="bi bi-grid-3x3-gap"></i>
            <div><h3><?php echo e($stats['available_chambers']); ?>/<?php echo e($stats['total_chambers']); ?></h3><p>Available Chambers</p></div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-card bg-dark-soft">
            <i class="bi bi-person-badge"></i>
            <div><h3><?php echo e($stats['staff_on_duty']); ?></h3><p>Staff on Duty</p></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><strong>Admissions vs Releases (Last 30 Days)</strong></div>
            <div class="card-body">
                <canvas id="trendChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><strong>Body Status Distribution</strong></div>
            <div class="card-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header"><strong>Chamber Occupancy</strong></div>
            <div class="card-body">
                <div class="chamber-grid">
                    <?php $__currentLoopData = $chambers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chamber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('chambers.show', $chamber)); ?>" class="chamber-box border-<?php echo e($chamber->status_color); ?>">
                            <div class="chamber-name"><?php echo e($chamber->name); ?></div>
                            <div class="chamber-status badge bg-<?php echo e($chamber->status_color); ?>"><?php echo e(ucfirst($chamber->status)); ?></div>
                            <div class="chamber-occ"><?php echo e($chamber->current_occupancy); ?>/<?php echo e($chamber->capacity); ?></div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header"><strong>Recent Admissions</strong></div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Ref No.</th><th>Name</th><th>Status</th><th>Admitted By</th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = $recentBodies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><a href="<?php echo e(route('bodies.show', $body)); ?>"><?php echo e($body->ref_number); ?></a></td>
                            <td><?php echo e($body->full_name); ?></td>
                            <td><span class="badge bg-<?php echo e($body->status_badge); ?>"><?php echo e(ucfirst(str_replace('_',' ', $body->status))); ?></span></td>
                            <td><?php echo e(optional($body->admittedBy)->full_name); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
        datasets: [
            { label: 'Admissions', data: <?php echo json_encode($admissions, 15, 512) ?>, borderColor: '#0d6efd', tension: 0.3 },
            { label: 'Releases', data: <?php echo json_encode($releases, 15, 512) ?>, borderColor: '#198754', tension: 0.3 },
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Admitted', 'In Storage', 'Released', 'Transferred'],
        datasets: [{ data: <?php echo json_encode($statusCounts, 15, 512) ?>, backgroundColor: ['#ffc107','#0dcaf0','#198754','#6c757d'] }]
    },
    options: { responsive: true }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/dashboard/index.blade.php ENDPATH**/ ?>