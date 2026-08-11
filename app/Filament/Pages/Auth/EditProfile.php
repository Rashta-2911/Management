<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Override;

class EditProfile extends BaseEditProfile
{
    protected static ?string $title = 'Edit Profile Saya';

    protected static ?string $navigationLabel = 'Edit Profile';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                $this->getEmailFormComponent()
                    ->label('Alamat Email'),
                $this->getPasswordFormComponent()
                    ->label('Kata Sandi Baru')
                    ->helperText('Biarkan kosong jika Anda tidak ingin mengubah kata sandi.'),
                $this->getPasswordConfirmationFormComponent()
                    ->label('Konfirmasi Kata Sandi Baru'),
            ]);
    }

    #[Override]
    public function getRedirectUrl(): ?string
    {
        return Filament::getPanel('admin')->getUrl();
    }
}
