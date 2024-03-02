<?php

namespace App\Http\Controllers\Admin;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class BaseAdminController extends Controller
{
    public function __construct()
    {
        $service = App::make(InertiaMetaInfoDto::class);
        $service->setTitle('');
        $service->setDescription('');
    }
}
