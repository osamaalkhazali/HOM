<?php

/**
 * Storage Diagnostic & Fix Script for iPage hosting
 * Upload this to your project root (same level as artisan) and open it in browser.
 * DELETE THIS FILE after use for security!
 *
 * Access: https://yourdomain.com/storage_fix.php
 */

// Simple security - change this password before uploading!
$password = 'HOM_FIX_2026!';

session_start();
if (isset($_POST['password']) && $_POST['password'] === $password) {
  $_SESSION['storage_fix_auth'] = true;
}
if (isset($_GET['logout'])) {
  unset($_SESSION['storage_fix_auth']);
}

if (empty($_SESSION['storage_fix_auth'])) {
  echo '<html><body style="font-family:Arial;max-width:400px;margin:80px auto;text-align:center">';
  echo '<h2>Storage Diagnostic Tool</h2>';
  echo '<form method="POST"><input type="password" name="password" placeholder="Enter password" style="padding:8px;width:200px"><br><br>';
  echo '<button type="submit" style="padding:8px 20px;background:#2563eb;color:white;border:none;border-radius:4px;cursor:pointer">Login</button></form></body></html>';
  exit;
}

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Support\SecureStorage;

$action = $_GET['action'] ?? 'diagnose';

?>
<!DOCTYPE html>
<html>

<head>
  <title>HOM Storage Fix</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 1000px;
      margin: 20px auto;
      padding: 0 20px;
      background: #f3f4f6;
    }

    h1 {
      color: #1e40af;
    }

    h2 {
      color: #374151;
      border-bottom: 2px solid #e5e7eb;
      padding-bottom: 8px;
    }

    .ok {
      color: #059669;
      font-weight: bold;
    }

    .fail {
      color: #dc2626;
      font-weight: bold;
    }

    .warn {
      color: #d97706;
      font-weight: bold;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 10px 0 20px;
    }

    th,
    td {
      border: 1px solid #d1d5db;
      padding: 8px;
      text-align: left;
      font-size: 13px;
    }

    th {
      background: #e5e7eb;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      margin: 15px 0;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    a.btn {
      display: inline-block;
      padding: 8px 16px;
      background: #2563eb;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      margin: 4px;
      font-size: 13px;
    }

    a.btn.danger {
      background: #dc2626;
    }

    a.btn.green {
      background: #059669;
    }

    pre {
      background: #1f2937;
      color: #e5e7eb;
      padding: 12px;
      border-radius: 6px;
      overflow-x: auto;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <h1>🔧 HOM Storage Diagnostic</h1>
  <p>
    <a href="?action=diagnose" class="btn">📊 Diagnose</a>
    <a href="?action=fix_dirs" class="btn green">📁 Create Directories</a>
    <a href="?action=fix_symlink" class="btn green">🔗 Fix Storage Symlink</a>
    <a href="?action=clear_cache" class="btn green">🗑️ Clear Cache</a>
    <a href="?logout=1" class="btn danger">Logout</a>
  </p>

  <?php if ($action === 'clear_cache'): ?>
    <div class="card">
      <h2>🗑️ Clear Cache</h2>
      <?php
      // Clear all caches
      $cachePaths = [
        base_path('bootstrap/cache/config.php'),
        base_path('bootstrap/cache/routes-v7.php'),
        base_path('bootstrap/cache/services.php'),
        base_path('bootstrap/cache/packages.php'),
      ];
      foreach ($cachePaths as $path) {
        if (file_exists($path)) {
          unlink($path);
          echo "<p class='ok'>✅ Deleted: " . basename($path) . "</p>";
        }
      }

      // Clear file-based cache
      $viewCache = storage_path('framework/views');
      if (is_dir($viewCache)) {
        $files = glob($viewCache . '/*');
        $count = 0;
        foreach ($files as $file) {
          if (is_file($file)) {
            unlink($file);
            $count++;
          }
        }
        echo "<p class='ok'>✅ Cleared {$count} compiled views</p>";
      }

      $appCache = storage_path('framework/cache/data');
      if (is_dir($appCache)) {
        $iterator = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($appCache, RecursiveDirectoryIterator::SKIP_DOTS),
          RecursiveIteratorIterator::CHILD_FIRST
        );
        $count = 0;
        foreach ($iterator as $item) {
          if ($item->isFile() && $item->getFilename() !== '.gitignore') {
            unlink($item->getRealPath());
            $count++;
          }
        }
        echo "<p class='ok'>✅ Cleared {$count} cache files</p>";
      }

      echo "<p class='ok'>✅ All caches cleared! Reload your site.</p>";
      ?>
    </div>

  <?php elseif ($action === 'fix_dirs'): ?>
    <div class="card">
      <h2>📁 Create Required Directories</h2>
      <?php
      $dirs = [
        storage_path('app'),
        storage_path('app/private'),
        storage_path('app/private/cvs'),
        storage_path('app/private/resumes'),
        storage_path('app/private/applications'),
        storage_path('app/private/applications/documents'),
        storage_path('app/private/applications/requested-documents'),
        storage_path('app/private/clients'),
        storage_path('app/private/clients/logos'),
        storage_path('app/private/employee_docs'),
        storage_path('app/public'),
        storage_path('app/public/clients'),
        storage_path('app/public/clients/logos'),
        storage_path('framework'),
        storage_path('framework/cache'),
        storage_path('framework/cache/data'),
        storage_path('framework/sessions'),
        storage_path('framework/views'),
        storage_path('logs'),
      ];
      foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
          if (mkdir($dir, 0755, true)) {
            echo "<p class='ok'>✅ Created: " . str_replace(base_path(), '', $dir) . "</p>";
          } else {
            echo "<p class='fail'>❌ Failed to create: " . str_replace(base_path(), '', $dir) . "</p>";
          }
        } else {
          echo "<p>📁 Already exists: " . str_replace(base_path(), '', $dir) . "</p>";
        }
      }

      // Create .gitignore files
      $gitignores = [
        storage_path('app/private/.gitignore') => "*\n!.gitignore\n",
        storage_path('app/public/.gitignore') => "*\n!.gitignore\n",
      ];
      foreach ($gitignores as $path => $content) {
        if (!file_exists($path)) {
          file_put_contents($path, $content);
          echo "<p class='ok'>✅ Created .gitignore in " . dirname(str_replace(base_path(), '', $path)) . "</p>";
        }
      }
      echo "<p class='ok'>✅ Directory setup complete!</p>";
      ?>
    </div>

  <?php elseif ($action === 'fix_symlink'): ?>
    <div class="card">
      <h2>🔗 Storage Symlink</h2>
      <?php
      $target = storage_path('app/public');
      $link = public_path('storage');

      echo "<p>Target: <code>{$target}</code></p>";
      echo "<p>Link: <code>{$link}</code></p>";

      if (is_link($link)) {
        echo "<p class='ok'>✅ Symlink already exists and points to: " . readlink($link) . "</p>";
      } elseif (is_dir($link)) {
        echo "<p class='warn'>⚠️ 'public/storage' exists as a real directory, not a symlink.</p>";
        echo "<p>On shared hosting, symlinks may not work. The directory approach is fine.</p>";
      } else {
        // Try to create symlink
        if (@symlink($target, $link)) {
          echo "<p class='ok'>✅ Symlink created successfully!</p>";
        } else {
          echo "<p class='warn'>⚠️ Could not create symlink (common on shared hosting).</p>";
          echo "<p>Alternative: Create 'public/storage' as a real directory or use File Manager to create it.</p>";

          // Try mkdir + copy approach
          if (mkdir($link, 0755, true)) {
            echo "<p class='ok'>✅ Created 'public/storage' as a real directory instead.</p>";
            echo "<p class='warn'>⚠️ Note: Files in storage/app/public won't auto-appear in public/storage. You'll need to copy them manually or use the private disk approach.</p>";
          }
        }
      }
      ?>
    </div>

  <?php else: ?>
    <!-- DIAGNOSE -->
    <div class="card">
      <h2>📊 Environment</h2>
      <table>
        <tr>
          <td>PHP Version</td>
          <td><?= phpversion() ?></td>
        </tr>
        <tr>
          <td>Laravel Version</td>
          <td><?= app()->version() ?></td>
        </tr>
        <tr>
          <td>APP_ENV</td>
          <td><?= config('app.env') ?></td>
        </tr>
        <tr>
          <td>APP_URL</td>
          <td><?= config('app.url') ?></td>
        </tr>
        <tr>
          <td>Base Path</td>
          <td><?= base_path() ?></td>
        </tr>
        <tr>
          <td>Storage Path</td>
          <td><?= storage_path() ?></td>
        </tr>
      </table>
    </div>

    <div class="card">
      <h2>📁 Directory Check</h2>
      <table>
        <tr>
          <th>Directory</th>
          <th>Exists</th>
          <th>Writable</th>
          <th>Permissions</th>
        </tr>
        <?php
        $checkDirs = [
          'storage/' => storage_path(),
          'storage/app/' => storage_path('app'),
          'storage/app/private/' => storage_path('app/private'),
          'storage/app/private/cvs/' => storage_path('app/private/cvs'),
          'storage/app/private/resumes/' => storage_path('app/private/resumes'),
          'storage/app/private/applications/' => storage_path('app/private/applications'),
          'storage/app/private/applications/documents/' => storage_path('app/private/applications/documents'),
          'storage/app/private/applications/requested-documents/' => storage_path('app/private/applications/requested-documents'),
          'storage/app/private/employee_docs/' => storage_path('app/private/employee_docs'),
          'storage/app/private/clients/' => storage_path('app/private/clients'),
          'storage/app/public/' => storage_path('app/public'),
          'storage/framework/' => storage_path('framework'),
          'storage/framework/cache/' => storage_path('framework/cache'),
          'storage/framework/sessions/' => storage_path('framework/sessions'),
          'storage/framework/views/' => storage_path('framework/views'),
          'storage/logs/' => storage_path('logs'),
          'public/storage (symlink)' => public_path('storage'),
        ];
        foreach ($checkDirs as $label => $path) {
          $exists = is_dir($path) || is_link($path);
          $writable = $exists && is_writable($path);
          $perms = $exists ? substr(sprintf('%o', fileperms($path)), -4) : '-';
          echo "<tr>";
          echo "<td>{$label}</td>";
          echo "<td class='" . ($exists ? 'ok' : 'fail') . "'>" . ($exists ? '✅ Yes' : '❌ No') . "</td>";
          echo "<td class='" . ($writable ? 'ok' : 'fail') . "'>" . ($writable ? '✅ Yes' : '❌ No') . "</td>";
          echo "<td>{$perms}</td>";
          echo "</tr>";
        }
        ?>
      </table>
    </div>

    <div class="card">
      <h2>📄 Files on Private Disk</h2>
      <?php
      try {
        $privateFiles = Storage::disk('private')->allFiles();
        echo "<p>Total files: <strong>" . count($privateFiles) . "</strong></p>";
        if (count($privateFiles) > 0) {
          echo "<table><tr><th>#</th><th>Path</th><th>Size</th></tr>";
          foreach (array_slice($privateFiles, 0, 50) as $i => $f) {
            if ($f === '.gitignore') continue;
            $size = Storage::disk('private')->size($f);
            $sizeStr = $size > 1048576 ? round($size / 1048576, 1) . ' MB' : round($size / 1024, 1) . ' KB';
            echo "<tr><td>" . ($i + 1) . "</td><td>{$f}</td><td>{$sizeStr}</td></tr>";
          }
          echo "</table>";
          if (count($privateFiles) > 50) echo "<p class='warn'>Showing first 50 of " . count($privateFiles) . "</p>";
        } else {
          echo "<p class='fail'>❌ No files found on private disk! Files may not have been uploaded/deployed.</p>";
        }
      } catch (Exception $e) {
        echo "<p class='fail'>❌ Error reading private disk: " . $e->getMessage() . "</p>";
      }
      ?>
    </div>

    <div class="card">
      <h2>🗄️ Database Records</h2>
      <table>
        <tr>
          <th>Table</th>
          <th>Total</th>
          <th>With File Path</th>
        </tr>
        <?php
        $counts = [
          'Applications' => [
            \App\Models\Application::count(),
            \App\Models\Application::whereNotNull('cv_path')->where('cv_path', '!=', '')->count()
          ],
          'Application Documents' => [
            \App\Models\ApplicationDocument::count(),
            \App\Models\ApplicationDocument::whereNotNull('file_path')->where('file_path', '!=', '')->count()
          ],
          'Application Doc Requests' => [
            \App\Models\ApplicationDocumentRequest::count(),
            \App\Models\ApplicationDocumentRequest::whereNotNull('file_path')->where('file_path', '!=', '')->count()
          ],
          'Profiles' => [
            \App\Models\Profile::count(),
            \App\Models\Profile::whereNotNull('cv_path')->where('cv_path', '!=', '')->count()
          ],
          'Employee Documents' => [
            \App\Models\EmployeeDocument::count(),
            \App\Models\EmployeeDocument::whereNotNull('file_path')->where('file_path', '!=', '')->count()
          ],
        ];
        foreach ($counts as $label => $c) {
          echo "<tr><td>{$label}</td><td>{$c[0]}</td><td>{$c[1]}</td></tr>";
        }
        ?>
      </table>
    </div>

    <div class="card">
      <h2>🔍 File Existence Check (DB paths vs Disk)</h2>
      <?php
      $missing = [];
      $found = [];

      // Check Application CVs
      $appCvs = \App\Models\Application::whereNotNull('cv_path')->where('cv_path', '!=', '')->select('id', 'cv_path')->get();
      foreach ($appCvs as $a) {
        if (SecureStorage::exists($a->cv_path)) {
          $found[] = "App CV #{$a->id}: {$a->cv_path}";
        } else {
          $missing[] = "App CV #{$a->id}: {$a->cv_path}";
        }
      }

      // Check Application Documents
      $appDocs = \App\Models\ApplicationDocument::whereNotNull('file_path')->where('file_path', '!=', '')->select('id', 'application_id', 'file_path')->get();
      foreach ($appDocs as $d) {
        if (SecureStorage::exists($d->file_path)) {
          $found[] = "AppDoc #{$d->id} (App:{$d->application_id}): {$d->file_path}";
        } else {
          $missing[] = "AppDoc #{$d->id} (App:{$d->application_id}): {$d->file_path}";
        }
      }

      // Check Requested Documents
      $reqDocs = \App\Models\ApplicationDocumentRequest::whereNotNull('file_path')->where('file_path', '!=', '')->select('id', 'application_id', 'file_path')->get();
      foreach ($reqDocs as $r) {
        if (SecureStorage::exists($r->file_path)) {
          $found[] = "ReqDoc #{$r->id} (App:{$r->application_id}): {$r->file_path}";
        } else {
          $missing[] = "ReqDoc #{$r->id} (App:{$r->application_id}): {$r->file_path}";
        }
      }

      // Check Profile CVs
      $profileCvs = \App\Models\Profile::whereNotNull('cv_path')->where('cv_path', '!=', '')->select('id', 'user_id', 'cv_path')->get();
      foreach ($profileCvs as $p) {
        if (SecureStorage::exists($p->cv_path)) {
          $found[] = "Profile #{$p->id} CV (User:{$p->user_id}): {$p->cv_path}";
        } else {
          $missing[] = "Profile #{$p->id} CV (User:{$p->user_id}): {$p->cv_path}";
        }
      }

      // Check Employee Documents
      $empDocs = \App\Models\EmployeeDocument::whereNotNull('file_path')->where('file_path', '!=', '')->select('id', 'employee_id', 'file_path')->get();
      foreach ($empDocs as $e) {
        $existsPrivate = Storage::disk('private')->exists($e->file_path);
        if ($existsPrivate) {
          $found[] = "EmpDoc #{$e->id} (Emp:{$e->employee_id}): {$e->file_path}";
        } else {
          $missing[] = "EmpDoc #{$e->id} (Emp:{$e->employee_id}): {$e->file_path}";
        }
      }

      echo "<p class='ok'>✅ Found: " . count($found) . " files exist on disk</p>";
      if (count($found) > 0) {
        echo "<details><summary>Show found files</summary><ul>";
        foreach ($found as $f) echo "<li style='font-size:12px'>{$f}</li>";
        echo "</ul></details>";
      }

      echo "<p class='" . (count($missing) > 0 ? 'fail' : 'ok') . "'>❌ Missing: " . count($missing) . " files NOT found on disk</p>";
      if (count($missing) > 0) {
        echo "<ul>";
        foreach ($missing as $m) echo "<li style='font-size:12px;color:#dc2626'>{$m}</li>";
        echo "</ul>";
      }

      if (count($missing) === 0 && count($found) === 0) {
        echo "<p class='warn'>⚠️ No file records in database. Did you seed or migrate the production database?</p>";
      }
      ?>
    </div>

    <div class="card">
      <h2>🛣️ Route Check</h2>
      <?php
      $routes = [
        'admin.applications.documents.download' => 'Admin download application document',
        'admin.applications.requested-documents.download' => 'Admin download requested document',
        'admin.applications.cv.download' => 'Admin download application CV',
        'admin.applications.cv.view' => 'Admin view application CV',
        'admin.users.cv.download' => 'Admin download user CV',
        'admin.users.cv.view' => 'Admin view user CV',
        'admin.employees.documents.download' => 'Admin download employee document',
        'admin.employees.documents.view' => 'Admin view employee document',
        'applications.documents.download' => 'User download application document',
        'applications.requested-documents.download' => 'User download requested document',
        'applications.cv.download' => 'User download own CV from application',
        'profile.cv.download' => 'User download own CV',
      ];
      echo "<table><tr><th>Route Name</th><th>Description</th><th>Status</th></tr>";
      foreach ($routes as $name => $desc) {
        try {
          $exists = \Illuminate\Support\Facades\Route::has($name);
          echo "<tr><td><code>{$name}</code></td><td>{$desc}</td>";
          echo "<td class='" . ($exists ? 'ok' : 'fail') . "'>" . ($exists ? '✅ Exists' : '❌ Missing') . "</td></tr>";
        } catch (Exception $e) {
          echo "<tr><td><code>{$name}</code></td><td>{$desc}</td><td class='fail'>❌ Error</td></tr>";
        }
      }
      echo "</table>";
      ?>
    </div>

    <div class="card">
      <h2>💡 Common Fixes for iPage</h2>
      <ol>
        <li><strong>Create directories:</strong> Click "📁 Create Directories" above</li>
        <li><strong>Storage symlink:</strong> Click "🔗 Fix Storage Symlink" above</li>
        <li><strong>Clear cache:</strong> Click "🗑️ Clear Cache" above (do this after ANY file changes)</li>
        <li><strong>File permissions:</strong> In iPage File Manager, set <code>storage/</code> folder permissions to <code>0755</code> recursively</li>
        <li><strong>Missing files:</strong> If DB has records but files are missing, the uploads were lost. Users need to re-upload.</li>
      </ol>
    </div>

  <?php endif; ?>

  <hr style="margin-top:30px">
  <p style="color:#dc2626;font-size:12px;text-align:center">⚠️ <strong>DELETE THIS FILE</strong> after use! It exposes sensitive information.</p>
</body>

</html>
<?php

// Clean up
unlink(__DIR__ . '/check_docs.php');
