<?php

namespace App\Filament\Admin\Resources\Coupons\Pages;

use App\Filament\Admin\Resources\Coupons\CouponResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCoupon extends CreateRecord
{
    protected static string $resource = CouponResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['team_id'] = \Filament\Facades\Filament::getTenant()->id;
        $data['created_by'] = \Filament\Facades\Filament::auth()->id();

        return $data;
    }
}
