<?php

if (!function_exists('jdd')) {
    /**
     * JSON-friendly dd() helper for APIs.
     *
     * @param  mixed  ...$vars
     * @return \Illuminate\Http\JsonResponse
     */
    function jdd(...$vars)
    {
        $backTrace = debug_backtrace();

        $dump = [];

        foreach ($vars as $index => $var) {
            $dump[$index] = $var;
        }

        response()->json([
            'dump' => $dump,
            'trace' => [
                'file' => $backTrace[0]['file'],
                'line' => $backTrace[0]['line'],
            ]
        ], 500, [], JSON_PRETTY_PRINT)->send();

        exit(1);
    }
}
