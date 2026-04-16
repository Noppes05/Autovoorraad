<?php

use App\Enums\Auto_status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

function makeActionRequest(User $user, array $data, array $files = []): Request
{
    $request = Request::create('/api/test', 'POST', $data, [], $files);
    $request->setUserResolver(fn () => $user);

    return $request;
}

function fakeImage(string $name): UploadedFile
{
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO5XjL0AAAAASUVORK5CYII=');

    return UploadedFile::fake()->createWithContent($name, $png);
}

function normalizeAutoStatus(mixed $status): Auto_status
{
    return $status instanceof Auto_status ? $status : Auto_status::from($status);
}