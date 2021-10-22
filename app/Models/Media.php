<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = ['display_name', 'display_url'];


    /**
     * Get all of the owning mediable models.
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    /**
     * Get display name for the media
     */
    public function getDisplayNameAttribute()
    {
        $array = explode('_', $this->file_name, 3);
        return !empty($array[2]) ? $array[2] : $array[1];
    }

    /**
     * Get display link for the media
     */
    public function getDisplayUrlAttribute()
    {
        $path = asset('/uploads/media/' . rawurlencode($this->file_name));

        return $path;
    }

    /**
     * Get display path for the media
     */
    public function getDisplayPathAttribute()
    {
        $path = public_path('uploads/media') . '/' . rawurlencode($this->file_name);

        return $path;
    }

    /**
     * Get display link for the media
     */
    public function thumbnail($size = [60, 60], $class = null)
    {
        $html = '<img';
        $html .= ' src="' . $this->display_url . '"';
        $html .= ' width="' . $size[0] . '"';
        $html .= ' height="' . $size[1] . '"';

        if (!empty($class)) {
            $html .= ' class="' . $class . '"';
        }

        $html .= '>';

        return $html;
    }

    /**
     * Uploads files from the request and add's medias to the supplied model.
     *
     * @param  int $system_settings_id, obj $model, $obj $request, string $file_name
     */
    public static function uploadMedia($system_settings_id, $model, $request, $file_name, $is_single = false, $model_media_type = null)
    {
        // //If app environment is demo return null
        // if (config('app.env') == 'demo') {
        //     return null;
        // }

        if ($request->hasFile($file_name)) {
            $files = $request->file($file_name);
            $uploaded_files = [];

            //If multiple files present
            if (is_array($files)) {
                foreach ($files as $file) {
                    $uploaded_file = Media::uploadFile($file);

                    if (!empty($uploaded_file)) {
                        $uploaded_files[] = $uploaded_file;
                    }
                }
            } else {
                $uploaded_file = Media::uploadFile($files);
                if (!empty($uploaded_file)) {
                    $uploaded_files[] = $uploaded_file;
                }
            }

            //If one to one relationship upload single file
            if ($is_single) {
                $uploaded_files = $uploaded_files[0];
            }
            
            // attach media to model
            Media::attachMediaToModel($model, $system_settings_id, $uploaded_files, $request, $model_media_type);
        }
    }

    /**
     * Uploads requested file to storage.
     *
     */
    public static function uploadFile($file)
    {
        $file_name = null;
        if ($file->getSize() <= config('constants.document_size_limit')) {
            $new_file_name = time() . '_' . mt_rand() . '_' . $file->getClientOriginalName();
            if ($file->storeAs('/media', $new_file_name)) {
                $file_name = $new_file_name;
            }
        }

        return $file_name;
    }

    /**
     * Deletes resource from database and storage
     *
     */
    public static function deleteMedia($system_settings_id, $media_id)
    {
        $media = Media::where('system_settings_id', $system_settings_id)
                        ->findOrFail($media_id);

        $media_path = public_path('uploads/media/' . $media->file_name);

        if (file_exists($media_path)) {
            unlink($media_path);
        }
        $media->delete();
    }

    public function uploaded_by_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    public static function attachMediaToModel($model, $system_settings_id, $uploaded_files, $request = null, $model_media_type = null)
    {
        if (!empty($uploaded_files)) {
            if (is_array($uploaded_files)) {
                $media_obj = [];
                foreach ($uploaded_files as $value) {
                    $media_obj[] = new \App\Models\Media([
                            'file_name' => $value,
                            'system_settings_id' => $system_settings_id,
                            'description' => !empty($request->description) ? $request->description : null,
                            'uploaded_by' => !empty($request->uploaded_by) ? $request->uploaded_by : auth()->user()->id,
                            'model_media_type' => $model_media_type
                        ]);
                }
                $model->media()->saveMany($media_obj);
            } else {
                //delete previous media if exists
                $model->media()->delete();
                
                $media_obj = new \App\Models\Media([
                        'file_name' => $uploaded_files,
                        'system_settings_id' => $system_settings_id,
                        'description' => !empty($request->description) ? $request->description : null,
                        'uploaded_by' => !empty($request->uploaded_by) ? $request->uploaded_by : auth()->user()->id,
                        'model_media_type' => $model_media_type
                    ]);
                $model->media()->save($media_obj);
            }
        }
    }
}
