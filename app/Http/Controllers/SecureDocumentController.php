<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Models\ApplicationDocumentRequest;
use App\Models\User;
use App\Support\SecureStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SecureDocumentController extends Controller
{
    /**
     * Download the authenticated user's CV.
     */
    public function downloadOwnCv(Request $request): StreamedResponse
    {
        return $this->streamUserCv($request->user());
    }

    /**
     * View the authenticated user's CV inline.
     */
    public function viewOwnCv(Request $request): StreamedResponse
    {
        return $this->streamUserCv($request->user(), 'inline');
    }

    /**
     * Download a user's CV (admin only).
     */
    public function downloadUserCv(User $user): StreamedResponse
    {
        $this->assertAdmin();

        return $this->streamUserCv($user);
    }

    /**
     * View a user's CV inline (admin only).
     */
    public function viewUserCv(User $user): StreamedResponse
    {
        $this->assertAdmin();

        return $this->streamUserCv($user, 'inline');
    }

    /**
     * Download an application's CV (owner or admin).
     */
    public function downloadApplicationCv(Application $application): StreamedResponse
    {
        return $this->streamApplicationCv($application, 'attachment');
    }

    /**
     * View an application's CV inline (owner or admin).
     */
    public function viewApplicationCv(Application $application): StreamedResponse
    {
        return $this->streamApplicationCv($application, 'inline');
    }

    /**
     * Download an uploaded supporting document (owner or admin).
     */
    public function downloadApplicationDocument(Application $application, ApplicationDocument $document): StreamedResponse
    {
        $this->assertApplicationAccess($application);
        $this->ensureDocumentMatch($application, $document);

        if (!$document->file_path) {
            abort(404);
        }

        $fileName = $document->original_name ?: basename($document->file_path);

        return $this->streamFile($document->file_path, $fileName);
    }

    /**
     * Download a requested document submission (owner or admin).
     */
    public function downloadRequestedDocument(Application $application, ApplicationDocumentRequest $documentRequest): StreamedResponse
    {
        $this->assertApplicationAccess($application);
        $this->ensureRequestedDocumentMatch($application, $documentRequest);

        if (!$documentRequest->file_path) {
            abort(404);
        }

        $name = $documentRequest->original_name ?: basename($documentRequest->file_path);

        return $this->streamFile($documentRequest->file_path, $name);
    }

    /**
     * View a requested document submission inline (admin only).
     */
    public function viewRequestedDocument(ApplicationDocumentRequest $documentRequest): StreamedResponse
    {
        $this->assertAdmin();

        if (!$documentRequest->file_path) {
            abort(404);
        }

        $application = $documentRequest->application;
        if ($application) {
            $this->assertApplicationAccess($application, true);
        }

        $name = $documentRequest->original_name ?: basename($documentRequest->file_path);

        return $this->streamFile($documentRequest->file_path, $name, 'inline');
    }

    /**
     * Stream the CV for the given user.
     */
    protected function streamUserCv(User $user, string $disposition = 'attachment'): StreamedResponse
    {
        $profile = $user->profile;

        if (!$profile || !$profile->cv_path) {
            abort(404);
        }

        return $this->streamFile($profile->cv_path, $this->buildCvFilename($user, $profile->cv_path), $disposition);
    }

    /**
     * Stream an application's CV with the desired disposition.
     */
    protected function streamApplicationCv(Application $application, string $disposition): StreamedResponse
    {
        $this->assertApplicationAccess($application);

        $cvPath = $application->cv_path ?: optional($application->user?->profile)->cv_path;

        if (!$cvPath) {
            abort(404);
        }

        $owner = $application->user;

        return $this->streamFile($cvPath, $this->buildCvFilename($owner, $cvPath), $disposition);
    }

    /**
     * Build a presentable CV filename.
     */
    protected function buildCvFilename(?User $user, string $path): string
    {
        $baseName = $user?->name ?: 'cv';
        $slug = preg_replace('/[^A-Za-z0-9\-]+/', '-', $baseName) ?: 'cv';
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        return $extension ? $slug . '.' . $extension : $slug;
    }

    /**
     * Stream a file from private storage.
     */
    protected function streamFile(string $path, string $filename, string $disposition = 'attachment'): StreamedResponse
    {
        $adapter = SecureStorage::resolveReadableAdapter($path);

        if (!$adapter) {
            abort(404);
        }

        $stream = $adapter->readStream($path);

        if ($stream === false) {
            abort(404);
        }

        $mimeType = $adapter->mimeType($path) ?: 'application/octet-stream';

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => $disposition . '; filename="' . addslashes($filename) . '"',
        ]);
    }

    protected function assertAdmin(): void
    {
        if (!Auth::guard('admin')->check()) {
            abort(403);
        }
    }

    protected function assertApplicationAccess(Application $application, bool $adminOnly = false): void
    {
        if (Auth::guard('admin')->check()) {
            return;
        }

        if ($adminOnly) {
            abort(403);
        }

        if (Auth::check() && $application->user_id === Auth::id()) {
            return;
        }

        abort(403);
    }

    protected function ensureDocumentMatch(Application $application, ApplicationDocument $document): void
    {
        if ($document->application_id !== $application->id) {
            abort(404);
        }
    }

    protected function ensureRequestedDocumentMatch(Application $application, ApplicationDocumentRequest $documentRequest): void
    {
        if ($documentRequest->application_id !== $application->id) {
            abort(404);
        }
    }
}
