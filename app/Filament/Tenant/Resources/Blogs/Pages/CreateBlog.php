<?php

namespace App\Filament\Tenant\Resources\Blogs\Pages;

use App\Filament\Tenant\Resources\Blogs\BlogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
}
