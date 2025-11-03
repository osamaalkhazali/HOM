<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, Employee $employee)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can upload documents
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|in:warning,appreciation,medical,contract,evaluation,promotion,resignation,other',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:10240', // 10MB max
            'notes' => 'nullable|string',
        ]);

        // Store the file with document type in path
        $filePath = $request->file('file')->store(
            'employee_docs/' . $employee->id . '/' . $validated['document_type'],
            'private'
        );

        // Create document record
        $document = $employee->documents()->create([
            'document_name' => $validated['document_name'],
            'document_type' => $validated['document_type'],
            'file_path' => $filePath,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.employees.show', $employee)
            ->with('success', 'Document uploaded successfully.');
    }

    /**
     * Download the specified document.
     */
    public function download(Employee $employee, EmployeeDocument $document)
    {
        $admin = Auth::guard('admin')->user();

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        // Verify the document belongs to this employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        if (!$document->fileExists()) {
            abort(404, 'File not found.');
        }

        return Storage::disk('private')->download($document->file_path, $document->document_name . '.' . $document->file_extension);
    }

    /**
     * View the specified document in browser.
     */
    public function view(Employee $employee, EmployeeDocument $document)
    {
        $admin = Auth::guard('admin')->user();

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        // Verify the document belongs to this employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        if (!$document->fileExists()) {
            abort(404, 'File not found.');
        }

        return response()->file(Storage::disk('private')->path($document->file_path));
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Employee $employee, EmployeeDocument $document)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can delete documents
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        // Verify the document belongs to this employee
        if ($document->employee_id !== $employee->id) {
            abort(404);
        }

        // Delete the file from storage
        if ($document->fileExists()) {
            Storage::disk('private')->delete($document->file_path);
        }

        // Delete the database record
        $document->delete();

        return redirect()
            ->route('admin.employees.show', $employee)
            ->with('success', 'Document deleted successfully.');
    }
}
