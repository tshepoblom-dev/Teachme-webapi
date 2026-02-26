<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileManager extends Controller
{
    protected $user;

    public function private_folder_name()
    {
        if (apiAuth() != null)
            return apiAuth()->id;

        if ($this->user != null)
            return $this->user->id;
    }

    public function base_directory()
    {
        return config('lfm.base_directory');
    }

    public function path()
    {
        return $this->private_folder_name();
    }

    public function __construct($file, $user = null, $sub_directory = null)
    {
        $this->user = $user;

        $fileName = $file->getClientOriginalName();

        // Build directory without double slashes — filter out null/empty segments
        // before joining, so "1087" + null never becomes "1087/"
        $segments = array_filter([$this->path(), $sub_directory], fn($s) => $s !== null && $s !== '');
        $path = implode('/', $segments);

        $storage_path = $file->storeAs($path, $fileName);

        // Collapse any remaining consecutive slashes just in case
        $this->storage_path = 'store/' . preg_replace('#/+#', '/', $storage_path);
    }

    public function __invoke(Request $request)
    {
        dd('dd');
    }
}