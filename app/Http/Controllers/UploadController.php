<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

use App\Models\TemporaryFile;
use App\Models\User;

use File;

class UploadController extends Controller
{
    public function store(Request $request){
        if($request->hasFile('attachment')){
            $file = $request->file('attachment');
            $filename = $file->getClientOriginalName();
            $folder = uniqid(). '-' .now()->timestamp;
            $file->storeAs('public/attachment/tmp/'. $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename
            ]);

            return $folder;
        }

        return '';
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $temporaryFile = TemporaryFile::where('folder', $request->attachment)->first();
        if($temporaryFile){
            $temporaryFile->delete();
            File::move(storage_path('app/public/attachment/tmp/'. $request->attachment), public_path('attachment/'. $request->attachment));

            // $path = storage_path('app/public/attachment/tmp/'. $request->attachment);
            // $this->emptyDir($path);
            // rmdir($path);
        }
    }

    function emptyDir($dir) {
        if (is_dir($dir)) {
            $scn = scandir($dir);
            foreach ($scn as $files) {
                if ($files !== '.') {
                    if ($files !== '..') {
                        if (!is_dir($dir . '/' . $files)) {
                            unlink($dir . '/' . $files);
                        } else {
                            emptyDir($dir . '/' . $files);
                            rmdir($dir . '/' . $files);
                        }
                    }
                }
            }
        }
    }
}
