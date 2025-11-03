<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
  /**
   * Display a listing of the clients.
   */
  public function index(Request $request)
  {
    $query = Client::query()->withCount(['jobs', 'applications']);

    if ($request->filled('search')) {
      $search = trim($request->input('search'));
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%");
      });
    }

    if ($request->filled('status')) {
      $status = $request->input('status');
      if ($status === 'active') {
        $query->where('is_active', true);
      } elseif ($status === 'inactive') {
        $query->where('is_active', false);
      }
    }

    $clients = $query
      ->orderBy('name')
      ->paginate(12)
      ->withQueryString();

    return view('admin.clients.index', compact('clients'));
  }

  /**
   * Show the form for creating a new client.
   */
  public function create()
  {
    return view('admin.clients.create');
  }

  /**
   * Store a newly created client in storage.
   */
  public function store(Request $request)
  {
    $data = $this->validateClient($request);
    $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? null, $data['name']);
    $data['is_active'] = $request->boolean('is_active', true);

    if ($request->hasFile('logo')) {
      $data['logo_path'] = $this->storeLogo($request->file('logo'));
    }

    $client = Client::create($data);

    return redirect()
      ->route('admin.clients.show', $client)
      ->with('success', 'Client created successfully.');
  }

  /**
   * Display the specified client.
   */
  public function show(Client $client)
  {
    $client->loadCount(['jobs', 'applications']);
    $jobs = $client->jobs()
      ->withCount('applications')
      ->latest('created_at')
      ->take(10)
      ->get();

    return view('admin.clients.show', compact('client', 'jobs'));
  }

  /**
   * Show the form for editing the specified client.
   */
  public function edit(Client $client)
  {
    return view('admin.clients.edit', compact('client'));
  }

  /**
   * Update the specified client in storage.
   */
  public function update(Request $request, Client $client)
  {
    $data = $this->validateClient($request, $client);
    $data['slug'] = $this->generateUniqueSlug($data['slug'] ?? null, $data['name'], $client);
    $data['is_active'] = $request->boolean('is_active', true);

    if ($request->boolean('remove_logo')) {
      $this->deleteLogo($client->logo_path);
      $data['logo_path'] = null;
    }

    if ($request->hasFile('logo')) {
      $this->deleteLogo($client->logo_path);
      $data['logo_path'] = $this->storeLogo($request->file('logo'));
    }

    $client->update($data);

    return redirect()
      ->route('admin.clients.edit', $client)
      ->with('success', 'Client updated successfully.');
  }

  /**
   * Remove the specified client from storage.
   */
  public function destroy(Client $client)
  {
    $this->deleteLogo($client->logo_path);
    $client->delete();

    return redirect()
      ->route('admin.clients.index')
      ->with('success', 'Client removed successfully.');
  }

  /**
   * Validate incoming request data.
   */
  protected function validateClient(Request $request, ?Client $client = null): array
  {
    return $request->validate([
      'name' => ['required', 'string', 'max:255'],
      'slug' => [
        'nullable',
        'string',
        'max:255',
        'regex:/^[A-Za-z0-9-]+$/',
        Rule::unique('clients', 'slug')->ignore($client?->id),
      ],
      'description' => ['nullable', 'string'],
      'website_url' => ['nullable', 'url', 'max:255'],
      'is_active' => ['sometimes', 'boolean'],
      'logo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
      'remove_logo' => ['sometimes', 'boolean'],
    ]);
  }

  /**
   * Generate a unique slug for the client.
   */
  protected function generateUniqueSlug(?string $slug, string $name, ?Client $ignore = null): string
  {
    $baseSlug = Str::slug($slug ?: $name);
    if (empty($baseSlug)) {
      $baseSlug = 'client';
    }

    $candidate = $baseSlug;
    $suffix = 1;

    while (
      Client::withTrashed()
      ->where('slug', $candidate)
      ->when($ignore, fn($query) => $query->where('id', '!=', $ignore->id))
      ->exists()
    ) {
      $candidate = $baseSlug . '-' . $suffix++;
    }

    return $candidate;
  }

  /**
   * Store the uploaded logo and return its storage path.
   */
  protected function storeLogo(UploadedFile $file): string
  {
    return $file->store('clients/logos', 'private');
  }

  /**
   * Delete a stored logo if it exists.
   */
  protected function deleteLogo(?string $path): void
  {
    if (!$path) {
      return;
    }

    $disk = Storage::disk('private');
    if ($disk->exists($path)) {
      $disk->delete($path);
    }
  }

  /**
   * Serve the client logo securely.
   */
  public function serveLogo(Client $client)
  {
    if (!$client->logo_path || !Storage::disk('private')->exists($client->logo_path)) {
      abort(404);
    }

    return response()->file(Storage::disk('private')->path($client->logo_path));
  }
}
