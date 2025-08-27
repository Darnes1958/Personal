<?php
namespace App\Http\Responses;
use Filament\Facades\Filament;
use Illuminate\Http\RedirectResponse;
use Filament\Auth\Http\Responses\LogoutResponse as BaseLogoutResponse;

class LogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        if (Filament::getCurrentPanel()->getId() === 'sell') {
            return redirect()->to(Filament::getLoginUrl());
        }
        return parent::toResponse($request);
    }
}
