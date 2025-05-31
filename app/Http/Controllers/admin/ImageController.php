<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log; // Added for logging

class ImageController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Image $image, Request $request)
    {
        try {
            $validatedPathPrefix = $request->validate([
                'path_prefix' => 'required|string' 
            ]);

            $filePath = 'public/' . $validatedPathPrefix['path_prefix'] . '/' . $image->name;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            } else {
                // Log if the file was not found, but still proceed to delete the DB record
                Log::warning('Image file not found in storage for deletion: ' . $filePath . ' (Image ID: ' . $image->id . ')');
            }

            $image->delete();

            return Redirect::back()->with('success', 'Image deleted successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return Redirect::back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('Error deleting image (ID: ' . $image->id . '): ' . $e->getMessage());
            return Redirect::back()->withErrors(['error' => 'Failed to delete image: ' . $e->getMessage()]);
        }
    }
} 