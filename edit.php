<?php
/**
 * ╔══════════════════════════════════════════════════╗
 * ║  Mini CMS — alexblanes.com                       ║
 * ║  Drop into public_html/ next to index.html       ║
 * ║  Visit: alexblanes.com/edit.php                  ║
 * ╚══════════════════════════════════════════════════╝
 *
 * What this does:
 *   1. Shows a login screen (single password)
 *   2. Loads your actual index.html with an editing overlay
 *   3. Click any text on your site to edit it visually
 *   4. Hit Save — writes straight back to index.html
 *   5. Keeps the last 5 backups automatically
 *
 * Setup:
 *   - Change the password below
 *   - Upload this file via FTP to public_html/
 *   - Bookmark alexblanes.com/edit.php
 */

// ── CONFIG ─────────────────────────────────────────
$PASSWORD_HASH = password_hash('seNdbPgjp7Gzn', PASSWORD_DEFAULT);
$TARGET     = __DIR__ . '/index.html';
$BACKUP_DIR = __DIR__ . '/.edit-backups';

// ── SESSION ────────────────────────────────────────
session_start();

// ── API: SAVE ──────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'save') {
    header('Content-Type: application/json');
    if (empty($_SESSION['minicms_auth'])) {
        http_response_code(401);
        die(json_encode(['error' => 'Not authenticated']));
    }

    $html = file_get_contents('php://input');
    if (strlen($html) < 200) {
        http_response_code(400);
        die(json_encode(['error' => 'Payload too small — something went wrong']));
    }

    // Auto-backup: keep last 5 versions
    if (!is_dir($BACKUP_DIR)) mkdir($BACKUP_DIR, 0755, true);
    copy($TARGET, $BACKUP_DIR . '/index.' . date('Ymd-His') . '.html');
    $backups = glob($BACKUP_DIR . '/index.*.html');
    rsort($backups);
    foreach (array_slice($backups, 5) as $old) @unlink($old);

    // Write the cleaned HTML
    file_put_contents($TARGET, $html);
    die(json_encode(['ok' => true, 'backup_count' => min(count($backups) + 1, 5)]));
}

// ── API: LIST BACKUPS ──────────────────────────────
if (($_GET['action'] ?? '') === 'backups' && !empty($_SESSION['minicms_auth'])) {
    header('Content-Type: application/json');
    $backups = glob($BACKUP_DIR . '/index.*.html');
    rsort($backups);
    $list = array_map(function($f) {
        preg_match('/index\.(\d{8}-\d{6})\.html$/', $f, $m);
        return ['file' => basename($f), 'date' => $m[1] ?? ''];
    }, array_slice($backups, 0, 5));
    die(json_encode($list));
}

// ── API: RESTORE BACKUP ────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_GET['action'] ?? '') === 'restore') {
    header('Content-Type: application/json');
    if (empty($_SESSION['minicms_auth'])) {
        http_response_code(401);
        die(json_encode(['error' => 'Not authenticated']));
    }
    $file = $_POST['file'] ?? '';
    $path = $BACKUP_DIR . '/' . basename($file);
    if (!file_exists($path)) {
        http_response_code(404);
        die(json_encode(['error' => 'Backup not found']));
    }
    // Backup current before restoring
    if (!is_dir($BACKUP_DIR)) mkdir($BACKUP_DIR, 0755, true);
    copy($TARGET, $BACKUP_DIR . '/index.' . date('Ymd-His') . '.html');
    copy($path, $TARGET);
    die(json_encode(['ok' => true]));
}

// ── LOGOUT ─────────────────────────────────────────
if (($_GET['action'] ?? '') === 'logout') {
    session_destroy();
    header('Location: edit.php');
    exit;
}

// ── LOGIN HANDLER ──────────────────────────────────
$loginError = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pw'])) {
    if (password_verify($PASSWORD, $_POST['pw'])) {
        $_SESSION['minicms_auth'] = true;
        header('Location: edit.php');
        exit;
    }
    $loginError = true;
}

// ── LOGIN SCREEN ───────────────────────────────────
if (empty($_SESSION['minicms_auth'])):
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Edit — alexblanes.com</title>
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: #f8f7f4;
    color: #2c2c2c;
  }
  .login-card {
    background: white;
    border-radius: 12px;
    padding: 2.5rem;
    width: 100%;
    max-width: 360px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
  }
  .login-card h1 {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
  }
  .login-card p {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 1.5rem;
  }
  .login-card input {
    width: 100%;
    padding: 0.7rem 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.95rem;
    margin-bottom: 1rem;
    outline: none;
    transition: border-color 0.2s;
  }
  .login-card input:focus { border-color: #5b6abf; }
  .login-card button {
    width: 100%;
    padding: 0.7rem;
    background: #5b6abf;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
  }
  .login-card button:hover { background: #4a58a8; }
  .error {
    background: #fff0f0;
    color: #c44;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    margin-bottom: 1rem;
  }
</style>
</head>
<body>
<div class="login-card">
  <h1>✏️ Site Editor</h1>
  <p>alexblanes.com</p>
  <?php if ($loginError): ?><div class="error">Wrong password — try again.</div><?php endif; ?>
  <form method="POST">
    <input type="password" name="pw" placeholder="Password" autofocus required>
    <button type="submit">Open Editor</button>
  </form>
</div>
</body>
</html>
<?php
exit;
endif;

// ── EDITOR MODE ────────────────────────────────────
// Read the actual index.html and inject editing capabilities

$html = file_get_contents($TARGET);
if (!$html) {
    die('Could not read ' . $TARGET);
}

// Define the editor overlay to inject
$editorInject = <<<'MINICMS'
<!-- ═══ MINICMS EDITOR — INJECTED, STRIPPED ON SAVE ═══ -->
<style id="minicms-styles">
  /* ── Editor toolbar ── */
  #minicms-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 99999;
    background: #2d3250;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0 1.25rem;
    height: 52px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 0.85rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.25);
  }
  #minicms-bar .bar-label {
    font-weight: 600;
    font-size: 0.9rem;
    margin-right: auto;
    display: flex;
    align-items: center;
    gap: 0.4rem;
  }
  #minicms-bar .bar-label .dot {
    width: 8px; height: 8px;
    background: #6ccb5f;
    border-radius: 50%;
    display: inline-block;
    animation: minicms-pulse 2s infinite;
  }
  @keyframes minicms-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
  }
  #minicms-bar button {
    padding: 0.4rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    font-family: inherit;
  }
  #minicms-bar .btn-save {
    background: #6ccb5f;
    color: #1a2a10;
  }
  #minicms-bar .btn-save:hover { background: #5dba50; }
  #minicms-bar .btn-save:disabled {
    background: #555;
    color: #999;
    cursor: not-allowed;
  }
  #minicms-bar .btn-secondary {
    background: rgba(255,255,255,0.12);
    color: white;
  }
  #minicms-bar .btn-secondary:hover { background: rgba(255,255,255,0.2); }
  #minicms-bar .btn-exit {
    background: rgba(255,255,255,0.08);
    color: #ccc;
  }
  #minicms-bar .btn-exit:hover { background: rgba(255,255,255,0.15); color: white; }

  /* ── Editable element styles ── */
  [data-minicms-editable] {
    outline: 2px dashed transparent;
    outline-offset: 4px;
    transition: outline-color 0.15s, background 0.15s;
    border-radius: 3px;
    cursor: text;
  }
  [data-minicms-editable]:hover {
    outline-color: rgba(91, 106, 191, 0.4);
  }
  [data-minicms-editable]:focus {
    outline-color: #5b6abf;
    outline-style: solid;
    background: rgba(91, 106, 191, 0.04);
  }

  /* ── Push page content below toolbar ── */
  body { margin-top: 52px !important; }

  /* ── Toast notifications ── */
  #minicms-toast {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(120px);
    background: #2d3250;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 0.9rem;
    font-weight: 500;
    z-index: 100000;
    transition: transform 0.3s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
  }
  #minicms-toast.visible { transform: translateX(-50%) translateY(0); }
  #minicms-toast.error { background: #c44; }
  #minicms-toast.success { background: #2d8a4e; }

  /* ── Change counter badge ── */
  #minicms-changes {
    background: rgba(255,255,255,0.15);
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
  }
  #minicms-changes.has-changes { background: #e8a63a; color: #2c2000; }
</style>

<div id="minicms-bar">
  <div class="bar-label"><span class="dot"></span> Edit Mode</div>
  <span id="minicms-changes">0 changes</span>
  <button class="btn-secondary" onclick="minicmsBackups()">Backups</button>
  <button class="btn-save" id="minicms-save-btn" onclick="minicmsSave()" disabled>Save</button>
  <a href="edit.php?action=logout" class="btn-exit" style="text-decoration:none;display:inline-block;padding:0.4rem 1rem;border-radius:6px;font-size:0.8rem;">Exit</a>
</div>
<div id="minicms-toast"></div>

<script id="minicms-script">
(function() {
  'use strict';

  let changeCount = 0;
  const saveBtn = document.getElementById('minicms-save-btn');
  const changesBadge = document.getElementById('minicms-changes');

  // ── Determine which elements to make editable ──
  // Target text-carrying elements inside main content sections
  const EDITABLE_SELECTORS = [
    // Headings
    'h1', 'h2', 'h3', 'h4',
    // Paragraphs and text blocks
    'p',
    // List items
    'li',
    // Specific site elements (by class patterns from the Astro build)
    '.cap-card-title', '.cap-card-desc',
    '.stat-value', '.stat-label',
    '.section-label', '.section-title',
    '.exp-title', '.exp-company', '.exp-date', '.exp-desc',
    '.edu-degree', '.edu-school', '.edu-date',
    '.fact-title', '.fact-desc',
    '.hero-tagline', '.hero-subtitle',
    'blockquote',
    'figcaption',
    // Table cells (if any)
    'td', 'th'
  ].join(', ');

  // Elements/areas to EXCLUDE from editing
  const EXCLUDE_SELECTORS = [
    '#minicms-bar', '#minicms-toast', '#minicms-styles', '#minicms-script',
    'nav', 'script', 'style', 'noscript', 'svg', 'iframe',
    '.btn', 'button', 'a.btn', '[role="button"]'
  ];

  function shouldExclude(el) {
    // Don't make nav, buttons, or editor UI editable
    for (const sel of EXCLUDE_SELECTORS) {
      if (el.matches(sel) || el.closest(sel)) return true;
    }
    // Skip elements with no meaningful text
    if (el.textContent.trim().length === 0) return true;
    // Skip elements that are just wrappers for other editable elements
    return false;
  }

  // ── Make elements editable ──
  document.querySelectorAll(EDITABLE_SELECTORS).forEach(el => {
    if (shouldExclude(el)) return;

    el.setAttribute('contenteditable', 'true');
    el.setAttribute('data-minicms-editable', 'true');
    el.setAttribute('spellcheck', 'true');

    // Track changes
    el.addEventListener('input', () => {
      changeCount++;
      updateChangesBadge();
    });

    // Prevent Enter from creating divs (keep clean HTML)
    el.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        // Allow Enter in list items and paragraphs, but insert <br> in single-line elements
        const tag = el.tagName.toLowerCase();
        if (!['p', 'li', 'blockquote', 'td', 'th'].includes(tag)) {
          e.preventDefault();
        }
      }
    });
  });

  function updateChangesBadge() {
    changesBadge.textContent = changeCount + ' change' + (changeCount !== 1 ? 's' : '');
    changesBadge.classList.toggle('has-changes', changeCount > 0);
    saveBtn.disabled = changeCount === 0;
  }

  // ── Toast helper ──
  function toast(msg, type) {
    const t = document.getElementById('minicms-toast');
    t.textContent = msg;
    t.className = 'visible ' + (type || '');
    clearTimeout(t._timer);
    t._timer = setTimeout(() => { t.className = ''; }, 3000);
  }

  // ── Save ──
  window.minicmsSave = async function() {
    if (changeCount === 0) return;

    saveBtn.disabled = true;
    saveBtn.textContent = 'Saving…';
    toast('Saving your changes…');

    try {
      // Clone the document and strip editor UI
      const clone = document.documentElement.cloneNode(true);

      // Remove all minicms elements
      clone.querySelectorAll('#minicms-bar, #minicms-toast, #minicms-styles, #minicms-script').forEach(el => el.remove());

      // Remove contenteditable attributes and data attributes
      clone.querySelectorAll('[data-minicms-editable]').forEach(el => {
        el.removeAttribute('contenteditable');
        el.removeAttribute('data-minicms-editable');
        el.removeAttribute('spellcheck');
      });

      // Remove the injected body margin-top
      const body = clone.querySelector('body');
      if (body) {
        body.style.marginTop = '';
        if (!body.getAttribute('style')) body.removeAttribute('style');
      }

      // Build clean HTML
      const cleanHTML = '<!DOCTYPE html>\n' + clone.outerHTML;

      const resp = await fetch('edit.php?action=save', {
        method: 'POST',
        headers: { 'Content-Type': 'text/html' },
        body: cleanHTML
      });

      const data = await resp.json();

      if (data.ok) {
        changeCount = 0;
        updateChangesBadge();
        toast('✓ Saved! Changes are live.', 'success');
      } else {
        toast('✗ Save failed: ' + (data.error || 'unknown error'), 'error');
      }
    } catch (err) {
      toast('✗ Save failed: ' + err.message, 'error');
    }

    saveBtn.disabled = changeCount === 0;
    saveBtn.textContent = 'Save';
  };

  // ── Keyboard shortcut: Cmd/Ctrl + S ──
  document.addEventListener('keydown', (e) => {
    if ((e.metaKey || e.ctrlKey) && e.key === 's') {
      e.preventDefault();
      if (changeCount > 0) minicmsSave();
    }
  });

  // ── Backups panel ──
  window.minicmsBackups = async function() {
    try {
      const resp = await fetch('edit.php?action=backups');
      const backups = await resp.json();

      if (backups.length === 0) {
        toast('No backups yet — they are created each time you save.', '');
        return;
      }

      const panel = document.createElement('div');
      panel.id = 'minicms-backup-panel';
      panel.style.cssText = 'position:fixed;inset:0;z-index:100001;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;font-family:-apple-system,BlinkMacSystemFont,sans-serif;';

      let listHTML = backups.map(b => {
        const d = b.date;
        const nice = d ? d.slice(0,4)+'-'+d.slice(4,6)+'-'+d.slice(6,8)+' '+d.slice(9,11)+':'+d.slice(11,13)+':'+d.slice(13,15) : b.file;
        return '<div style="display:flex;align-items:center;justify-content:space-between;padding:0.6rem 0;border-bottom:1px solid #eee;">' +
          '<span style="font-size:0.9rem;color:#333;">' + nice + '</span>' +
          '<button onclick="minicmsRestore(\'' + b.file + '\')" style="padding:0.3rem 0.8rem;background:#e8a63a;border:none;border-radius:5px;font-size:0.8rem;cursor:pointer;font-weight:500;">Restore</button>' +
          '</div>';
      }).join('');

      panel.innerHTML = '<div style="background:white;border-radius:12px;padding:1.75rem;width:100%;max-width:420px;box-shadow:0 8px 40px rgba(0,0,0,0.2);">' +
        '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">' +
          '<h3 style="margin:0;font-size:1rem;">Backups</h3>' +
          '<button onclick="this.closest(\'#minicms-backup-panel\').remove()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:#999;">✕</button>' +
        '</div>' +
        '<p style="font-size:0.8rem;color:#888;margin-bottom:1rem;">Restoring replaces index.html with the selected backup (and backs up the current version first).</p>' +
        listHTML +
        '</div>';

      document.body.appendChild(panel);
      panel.addEventListener('click', (e) => { if (e.target === panel) panel.remove(); });
    } catch (err) {
      toast('Could not load backups: ' + err.message, 'error');
    }
  };

  window.minicmsRestore = async function(file) {
    if (!confirm('Restore this backup? (Your current version will be backed up first.)')) return;

    try {
      const form = new FormData();
      form.append('file', file);
      const resp = await fetch('edit.php?action=restore', { method: 'POST', body: form });
      const data = await resp.json();

      if (data.ok) {
        toast('✓ Restored! Reloading…', 'success');
        setTimeout(() => location.reload(), 1000);
      } else {
        toast('✗ Restore failed: ' + (data.error || 'unknown'), 'error');
      }
    } catch (err) {
      toast('✗ Restore failed: ' + err.message, 'error');
    }
  };

  // ── Warn before leaving with unsaved changes ──
  window.addEventListener('beforeunload', (e) => {
    if (changeCount > 0) {
      e.preventDefault();
      e.returnValue = '';
    }
  });

  // ── Init complete ──
  console.log('🖊️ Mini CMS loaded — ' + document.querySelectorAll('[data-minicms-editable]').length + ' editable elements found');
})();
</script>
<!-- ═══ /MINICMS EDITOR ═══ -->
MINICMS;

// Inject before </body>
$html = str_replace('</body>', $editorInject . "\n</body>", $html);

echo $html;
