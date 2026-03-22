<?php
// Shared form fields used by both create.php and edit.php
// $project array populated by edit.php, empty array for create.php
$p = $project ?? [];
$v = function(string $key, string $default = '') use ($p): string {
    return htmlspecialchars($p[$key] ?? $default, ENT_QUOTES, 'UTF-8');
};
$stackArr  = json_decode($p['stack']        ?? '[]', true) ?: [];
$colorsArr = json_decode($p['stack_colors'] ?? '[]', true) ?: [];
$imagesArr = json_decode($p['images']       ?? '[]', true) ?: [];
?>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
    <!-- Title -->
    <div class="sm:col-span-2">
        <label class="form-label">عنوان المشروع <span class="text-red-400">*</span></label>
        <input type="text" name="title" required value="<?= $v('title') ?>" class="form-input" placeholder="e.g. منصة تعليمية MERN">
    </div>

    <!-- Type -->
    <div>
        <label class="form-label">نوع المشروع</label>
        <input type="text" name="type" value="<?= $v('type') ?>" class="form-input" placeholder="e.g. MERN Stack">
    </div>

    <!-- Sort Order -->
    <div>
        <label class="form-label">الترتيب</label>
        <input type="number" name="sort_order" value="<?= $v('sort_order', '0') ?>" class="form-input" min="0">
    </div>

    <!-- Type BG -->
    <div>
        <label class="form-label">لون الخلفية (type_bg)</label>
        <input type="text" name="type_bg" value="<?= $v('type_bg', 'rgba(255,255,255,0.1)') ?>"
               class="form-input" placeholder="rgba(245,230,66,0.1)">
    </div>

    <!-- Type Color -->
    <div>
        <label class="form-label">لون النص (type_color)</label>
        <div class="flex gap-2">
            <input type="text" name="type_color" id="typeColorText" value="<?= $v('type_color', '#ffffff') ?>"
                   class="form-input flex-1" placeholder="#F5E642">
            <input type="color" id="typeColorPicker" value="<?= $v('type_color', '#ffffff') ?>"
                   class="w-12 h-10 rounded-lg border border-white/10 bg-slate-800 cursor-pointer p-1">
        </div>
    </div>

    <!-- Short Desc -->
    <div class="sm:col-span-2">
        <label class="form-label">وصف مختصر</label>
        <input type="text" name="short_desc" value="<?= $v('short_desc') ?>"
               class="form-input" placeholder="وصف قصير يظهر في البطاقة">
    </div>

    <!-- Full Desc -->
    <div class="sm:col-span-2">
        <label class="form-label">وصف تفصيلي</label>
        <textarea name="full_desc" rows="4" class="form-input resize-none"
                  placeholder="وصف مفصّل يظهر في صفحة تفاصيل المشروع"><?= $v('full_desc') ?></textarea>
    </div>

    <!-- Live URL -->
    <div>
        <label class="form-label">رابط الموقع (live URL)</label>
        <input type="text" name="live_url" value="<?= $v('live_url', '#') ?>"
               class="form-input" placeholder="https://...">
    </div>

    <!-- GitHub URL -->
    <div>
        <label class="form-label">رابط GitHub</label>
        <input type="text" name="github_url" value="<?= $v('github_url', '#') ?>"
               class="form-input" placeholder="https://github.com/...">
    </div>
</div>

<!-- Stack + Colors -->
<div class="bg-slate-800/40 border border-white/5 rounded-xl p-5 space-y-3">
    <div class="flex items-center justify-between">
        <label class="text-sm font-semibold text-white">التقنيات المستخدمة (Stack)</label>
        <button type="button" onclick="addStackRow()"
                class="text-xs px-3 py-1.5 bg-sky-500/20 text-sky-400 rounded-lg hover:bg-sky-500/30 transition-all">
            + إضافة تقنية
        </button>
    </div>
    <div id="stack-container" class="space-y-2">
        <?php
        $maxRows = max(count($stackArr), count($colorsArr), 1);
        for ($i = 0; $i < $maxRows; $i++):
            $tag   = htmlspecialchars($stackArr[$i] ?? '', ENT_QUOTES);
            $color = htmlspecialchars($colorsArr[$i] ?? 'tag-teal', ENT_QUOTES);
        ?>
        <div class="flex gap-2 stack-row">
            <input type="text" name="stack[]" value="<?= $tag ?>" placeholder="MongoDB"
                   class="form-input flex-1 text-sm">
            <select name="stack_colors[]" class="form-input w-36 text-sm">
                <?php foreach (['tag-teal','tag-orange','tag-yellow','tag-pink','tag-purple','tag-blue'] as $c): ?>
                    <option value="<?= $c ?>" <?= $color === $c ? 'selected' : '' ?>><?= $c ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" onclick="this.closest('.stack-row').remove()"
                    class="px-2.5 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-all text-xs">✕</button>
        </div>
        <?php endfor; ?>
    </div>
</div>

<!-- Images -->
<div class="bg-slate-800/40 border border-white/5 rounded-xl p-5 space-y-3">
    <div class="flex items-center justify-between">
        <label class="text-sm font-semibold text-white">صور المشروع (روابط)</label>
        <button type="button" onclick="addImageRow()"
                class="text-xs px-3 py-1.5 bg-sky-500/20 text-sky-400 rounded-lg hover:bg-sky-500/30 transition-all">
            + إضافة صورة
        </button>
    </div>
    <div id="images-container" class="space-y-2">
        <?php
        $imgs = count($imagesArr) > 0 ? $imagesArr : [''];
        foreach ($imgs as $img):
            $imgVal = htmlspecialchars($img, ENT_QUOTES);
        ?>
        <div class="flex gap-2 image-row">
            <input type="text" name="images[]" value="<?= $imgVal ?>" placeholder="https://images.unsplash.com/..."
                   class="form-input flex-1 text-sm">
            <button type="button" onclick="this.closest('.image-row').remove()"
                    class="px-2.5 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-all text-xs">✕</button>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .form-label { @apply block text-sm text-slate-300 font-medium mb-1.5; }
    .form-input  { @apply w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-slate-500
                         focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500/50 transition-all text-sm; }
    /* Override defaults for select to look better on dark mode */
    select.form-input { @apply appearance-none bg-slate-800 text-white pr-8; }
</style>
<script>
function addStackRow() {
    const c = document.getElementById('stack-container');
    c.insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 stack-row">
            <input type="text" name="stack[]" placeholder="Technology" class="form-input flex-1 text-sm">
            <select name="stack_colors[]" class="form-input w-36 text-sm">
                <option value="tag-teal">tag-teal</option>
                <option value="tag-orange">tag-orange</option>
                <option value="tag-yellow">tag-yellow</option>
                <option value="tag-pink">tag-pink</option>
                <option value="tag-purple">tag-purple</option>
                <option value="tag-blue">tag-blue</option>
            </select>
            <button type="button" onclick="this.closest('.stack-row').remove()"
                    class="px-2.5 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-all text-xs">✕</button>
        </div>`);
}
function addImageRow() {
    const c = document.getElementById('images-container');
    c.insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 image-row">
            <input type="text" name="images[]" placeholder="https://..." class="form-input flex-1 text-sm">
            <button type="button" onclick="this.closest('.image-row').remove()"
                    class="px-2.5 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 rounded-lg transition-all text-xs">✕</button>
        </div>`);
}
// Color picker sync
const picker = document.getElementById('typeColorPicker');
const text   = document.getElementById('typeColorText');
if (picker && text) {
    picker.addEventListener('input', () => text.value = picker.value);
    text.addEventListener('input', () => { if (/^#[0-9a-fA-F]{6}$/.test(text.value)) picker.value = text.value; });
}
</script>
