<?php

// Get Auth User
if (!function_exists('add_media')) {
    function add_media($model, $request, $collection)
    {
        if ($request->hasFile('media')) {
            $model->addMediaFromRequest('media')->toMediaCollection($collection);
        }
    }
}
