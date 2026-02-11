<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class VideoStreamController extends Controller
{
    public function stream(Request $request)
    {
        $relativePath = $request->query('file');

        if (!$relativePath) {
            abort(400, 'File path not provided');
        }
        $relativePath = str_replace(['../', './'], '', $relativePath);

        $path = public_path("uploads/videos/" . $relativePath);

        if (!File::exists($path)) {
            abort(404);
        }

        $size = File::size($path);
        $mime = File::mimeType($path);

        $headers = [
            'Content-Type'   => $mime,
            'Accept-Ranges'  => 'bytes',
        ];
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            list(, $range) = explode('=', $range, 2);
            list($start, $end) = array_pad(explode('-', $range), 2, null);

            $start = intval($start);
            $end   = $end ? intval($end) : $size - 1;

            $length = $end - $start + 1;

            $headers['Content-Range']  = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            $stream = fopen($path, 'rb');
            fseek($stream, $start);

            return response()->stream(function () use ($stream, $length) {
                echo fread($stream, $length);
                fclose($stream);
            }, 206, $headers);
        }

        return Response::file($path, $headers);
    }
}
