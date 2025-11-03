# Employee Management Permissions Update

## Changes Made

### Authorization Update

Changed employee management permissions so that:

-   **Client HR**: Can create, edit, delete employees and upload/delete documents
-   **Admin/Super Admin**: Can only **view** employees (read-only access)

## Updated Files

### Controllers

#### `app/Http/Controllers/Admin/EmployeeController.php`

-   **create()**: Added check - only Client HR can access
-   **store()**: Added check - only Client HR can create
-   **edit()**: Added check - only Client HR can access
-   **update()**: Added check - only Client HR can update
-   **destroy()**: Added check - only Client HR can delete

#### `app/Http/Controllers/Admin/EmployeeDocumentController.php`

-   **store()**: Added check - only Client HR can upload documents
-   **destroy()**: Added check - only Client HR can delete documents
-   **download()** & **view()**: Remain accessible to all roles (read-only)

### Views

#### `resources/views/admin/employees/index.blade.php`

-   "Add Employee" button: Only visible to Client HR
-   Edit/Delete action buttons: Only visible to Client HR
-   View button: Visible to all roles

#### `resources/views/admin/employees/show.blade.php`

-   "Edit Employee" button: Only visible to Client HR
-   "Delete" button: Only visible to Client HR
-   "Upload Document" button: Only visible to Client HR
-   Document delete button: Only visible to Client HR
-   View and Download buttons: Visible to all roles

#### `resources/views/layouts/admin/sidebar.blade.php`

-   "Add New Employee" menu item: Only visible to Client HR
-   Other menu items: Visible to all roles

## Role Permissions Summary

### Client HR

✅ View all employees (for their client only)
✅ Create new employees
✅ Edit employee records
✅ Delete employee records
✅ Upload employee documents
✅ Delete employee documents
✅ Download/view employee documents

### Admin/Super Admin

✅ View all employees (across all clients)
✅ Filter employees by client
✅ Download/view employee documents
❌ Create employees
❌ Edit employees
❌ Delete employees
❌ Upload documents
❌ Delete documents

## Security

-   All authorization checks implemented at controller level
-   UI buttons/links hidden based on role (defense in depth)
-   Client HR can only manage employees from their assigned client
-   Admins have read-only access for oversight purposes
