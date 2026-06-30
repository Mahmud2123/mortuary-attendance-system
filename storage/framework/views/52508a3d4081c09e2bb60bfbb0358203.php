<?php $__env->startSection('title', 'Process Release'); ?>

<?php $__env->startSection('content'); ?>
<h3 class="mb-4">Process Body Release</h3>

<div class="card">
    <div class="card-body">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger"><ul class="mb-0 ps-3"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
        <?php endif; ?>

        <!-- Step indicator -->
        <div class="step-indicator mb-4">
            <span class="step active" data-step="1">1. Select Body</span>
            <span class="step" data-step="2">2. Verify Next of Kin</span>
            <span class="step" data-step="3">3. Confirm &amp; Release</span>
        </div>

        <form method="POST" action="<?php echo e(route('releases.store')); ?>" id="releaseForm">
            <?php echo csrf_field(); ?>

            <!-- Step 1 -->
            <div class="release-step" id="stepPane1">
                <label class="form-label">Select Body to Release *</label>
                <select id="bodySelect" name="body_id" class="form-select" required>
                    <option value="">-- Choose a body --</option>
                    <?php $__currentLoopData = $bodies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($body->id); ?>" data-kins='<?php echo json_encode($body->nextOfKins, 15, 512) ?>'>
                            <?php echo e($body->ref_number); ?> — <?php echo e($body->full_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="button" class="btn btn-primary mt-3" onclick="goToStep(2)">Next</button>
            </div>

            <!-- Step 2 -->
            <div class="release-step d-none" id="stepPane2">
                <label class="form-label">Select Verified Next of Kin *</label>
                <div id="kinList" class="mb-3"></div>
                <p class="text-muted small" id="noKinMsg" style="display:none;">No next of kin recorded for this body. Please add one from the body's detail page before releasing.</p>
                <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">Back</button>
                <button type="button" class="btn btn-primary" onclick="goToStep(3)">Next</button>
            </div>

            <!-- Step 3 -->
            <div class="release-step d-none" id="stepPane3">
                <div class="mb-3">
                    <label class="form-label">Release Date *</label>
                    <input type="date" name="release_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="confirm" class="form-check-input" id="confirmCheck" required>
                    <label class="form-check-label" for="confirmCheck">
                        I confirm the identity of the next of kin has been verified and authorization documents are in order.
                    </label>
                </div>
                <button type="button" class="btn btn-outline-secondary" onclick="goToStep(2)">Back</button>
                <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Confirm Release</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function goToStep(n) {
    document.querySelectorAll('.release-step').forEach(el => el.classList.add('d-none'));
    document.getElementById('stepPane' + n).classList.remove('d-none');
    document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
    document.querySelector(`.step[data-step="${n}"]`).classList.add('active');

    if (n === 2) loadKins();
}

function loadKins() {
    const select = document.getElementById('bodySelect');
    const opt = select.options[select.selectedIndex];
    const kins = JSON.parse(opt.dataset.kins || '[]');
    const list = document.getElementById('kinList');
    const noKinMsg = document.getElementById('noKinMsg');
    list.innerHTML = '';

    if (kins.length === 0) {
        noKinMsg.style.display = 'block';
        return;
    }
    noKinMsg.style.display = 'none';

    kins.forEach(kin => {
        const div = document.createElement('div');
        div.className = 'form-check border rounded p-2 mb-2';
        div.innerHTML = `
            <input class="form-check-input" type="radio" name="kin_id" id="kin${kin.id}" value="${kin.id}" required>
            <label class="form-check-label w-100" for="kin${kin.id}">
                <strong>${kin.full_name}</strong> — ${kin.relationship}<br>
                <span class="text-muted small">${kin.phone} ${kin.id_type ? '| ' + kin.id_type + ': ' + kin.id_number : ''}</span>
            </label>`;
        list.appendChild(div);
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\mortuary\resources\views/releases/create.blade.php ENDPATH**/ ?>