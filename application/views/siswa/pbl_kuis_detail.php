<style>
    #questionsTable.table > :not(caption) > * > * {
        padding: 0;
        border-bottom-width: 0;
    }
    #questionsTable thead { display: none; }
    
    .question-card {
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        background-color: #fff;
    }
    .option-label {
        display: block;
        padding: 8px 12px;
        border: 1px solid #d1d3e2;
        border-radius: 5px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .option-label:hover { background-color: #f8f9fc; }
    .form-check-input:checked + .option-label {
        background-color: #e7f1ff;
        border-color: #4e73df;
        color: #2e59d9;
        font-weight: bold;
    }
    .form-check-input { display: none; } 
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1"><?= $title; ?></h4>
            <p class="text-muted"><?= htmlspecialchars($quiz->description, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
        <a href="<?= base_url('siswa/pbl/tahap2/' . $class_id) ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <?php if ($result): ?>
        <div class="alert alert-success text-center shadow-sm">
            <h4 class="alert-heading"><i class="bi bi-check-circle-fill"></i> Selesai!</h4>
            <p>Anda telah menyelesaikan kuis ini.</p>
            <hr>
            <h1 class="display-4 fw-bold"><?= $result->score; ?></h1>
            <p class="mb-0">Benar: <?= $result->total_correct; ?> dari <?= $result->total_questions; ?> Soal</p>
        </div>
    <?php else: ?>
        <form id="quizSubmissionForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            
            <div id="questionsTableContainer">
                <table class="table" id="questionsTable">
                    <thead><tr><th>Soal</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="d-grid gap-2 mt-4 mb-5">
                <button type="submit" class="btn btn-primary btn-lg" id="btnSubmitQuiz">
                    <i class="bi bi-send"></i> Kirim Jawaban
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
    window.BASE_URL = "<?= base_url(); ?>";
    window.CSRF_TOKEN_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
    window.QUIZ_ID = "<?= $quiz->id; ?>";
</script>

<?php if (!$result): ?>
<script type="module" src="<?= base_url('assets/js/siswa/pbl_kuis_detail.js'); ?>"></script>
<?php endif; ?>