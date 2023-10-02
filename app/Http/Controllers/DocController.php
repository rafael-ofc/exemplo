<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocController extends Controller
{
    public function read()
    {
        $docs = Doc::all();

        foreach ($docs as $doc) {
            $doc['path'] = asset("storage/docs/$doc->path");
        }

        return [
            'error' => '',
            'list' => $docs,
        ];
    }
}
