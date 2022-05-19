<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\Request;
use Filament\Resources\Pages\Page;

class ViewRequest extends Page
{
    protected static string $resource = RequestResource::class;
    protected static ?string $title = 'Detail Permintaan Produk';
    protected static string $view = 'filament.resources.request-resource.pages.view-request';


    public ?Request $request;

    public function mount(Request $record)
    {

        $this->request = $record;
    }

}
