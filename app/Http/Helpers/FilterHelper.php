<?php

namespace App\Helpers;

class FilterHelper
{
    public static function removeFilter($key, $value = null)
    {
        $query = request()->query();
        
        if ($value && isset($query[$key]) && is_array($query[$key])) {
            $query[$key] = array_diff($query[$key], [$value]);
            if (empty($query[$key])) {
                unset($query[$key]);
            }
        } else {
            unset($query[$key]);
        }
        
        // Remove page parameter to go back to first page
        unset($query['page']);
        
        $url = url()->current();
        return !empty($query) ? $url . '?' . http_build_query($query) : $url;
    }
    
    public static function buildQuery($params = [])
    {
        $currentQuery = request()->query();
        $merged = array_merge($currentQuery, $params);
        unset($merged['page']); // Remove page when changing filters
        
        $url = url()->current();
        return !empty($merged) ? $url . '?' . http_build_query($merged) : $url;
    }
}